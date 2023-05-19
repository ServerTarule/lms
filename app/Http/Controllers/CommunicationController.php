<?php

namespace App\Http\Controllers;

use App\Mail\Campaign;
use App\Models\Communication;
use App\Models\CommunicationLead;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\Template;
use App\Notifications\LeadConnect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Lorisleiva\CronTranslator\CronTranslator;

class CommunicationController extends Controller
{
    public function index()
    {
        $rules = Rule::all();
        $templates = Template::all();
        $communications = Communication::all();
        return view('communications.index', compact('rules', 'templates', 'communications'));
    }

    public function show($id) : JsonResponse {
        $communication = Communication::where('id', $id)->get()->first();
        return response()->json([
            'schedule' => $communication,
            'success' => 'Received rule data'
        ]);
    }

    public function store(Request $request) : RedirectResponse {

        Log::info("*** Communication Request ***");
        Log::info($request);
        $communicationType = $request->schedule;

        if ($communicationType == 'scheduled') {

            $communicationTemplateType = $request->communicationTemplateType;
            $communicationTemplateId = $request->communicationTemplateId;
            $communicationTemplateMessage = $request->communicationTemplateMessage;
            $communicationTemplateSubject = $request->communicationTemplateSubject;
            $communicationTemplateBody = $request->communicationTemplateBody;

            $scheduleUnit = $request->scheduleUnit;
            $dayOfWeek = $request->dayOfWeek;
            $dayOfMonth = $request->dayOfMonth;

            $ruleId = $request->ruleId;

            $minuteHour = $request->minuteHour;
            $schedule = null;

            if ($scheduleUnit == 'DAILY') {
                $dayOfWeek = "*";
                $dayOfMonth = "*";
            }

            if ($scheduleUnit == 'WEEKLY') {
                $dayOfMonth = "*";
            }

            if(!is_null($minuteHour)) {
                $hour = substr($minuteHour, 0, 2);
                $min = substr($minuteHour, 3, 2);
                $schedule = $min.' '.$hour.' '.$dayOfMonth.' '.'*'.' '.$dayOfWeek;
            }

            $words = CronTranslator::translate($schedule);

//        Log::info($minuteHour);
//        Log::info($schedule);

            //0 0 * * *
            //MIN HR DAY-OF-MONTH MONTH DAY-OF-WEEK

            $communicationSchedule = Communication::create([
                'type'=>$communicationTemplateType,
                'message'=>$communicationTemplateMessage,
                'subject'=>$communicationTemplateSubject,
                'content'=>$communicationTemplateBody,
                'schedule'=>$schedule,
                'words'=>$words,
                'template_id'=>$communicationTemplateId,
                'rule_id'=>$ruleId
            ]);
        } else if ($communicationType == 'now') {

            $ruleId = $request->ruleId;
            $ruleConditions = RuleCondition::where('rule_id', $ruleId)->orderBy('master_id', 'asc')->get();

            $leadIdsMatchingRuleCondition = array();
            foreach ($ruleConditions as $ruleCondition) {
                $matchCase = ['master_id' => $ruleCondition->master_id, 'mastervalue_id' => $ruleCondition->mastervalue_id];
                $leadMastersMatchingRuleConditionMaster = LeadMaster::where($matchCase)->get();
                foreach ($leadMastersMatchingRuleConditionMaster as $leadMasterMatchingRuleConditionMaster) {
                    $leadIdsMatchingRuleCondition[] = $leadMasterMatchingRuleConditionMaster->lead_id;
                }
            }

            $uniqueLeadIdsMatchingRuleCondition = collect($leadIdsMatchingRuleCondition)->unique();

            $leadMatchingRule = array();
            foreach ($uniqueLeadIdsMatchingRuleCondition as $leadId) {
                $leadMasters = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->orderBy('master_id', 'asc')->get();
                $leadMastersCount = count($leadMasters);
                $leadEvaluation = array();

                foreach ($ruleConditions as $ruleCondition) {
                    foreach ($leadMasters as $leadMaster) {
                        if ($ruleCondition->master_id == $leadMaster->master_id && $ruleCondition->mastervalue_id == $leadMaster->mastervalue_id) {
                            if ($leadMastersCount == 1) {
                                $leadEvaluation[] = true;
                                break;
                            } else {
                                $leadEvaluation[] = true;
                                if (!is_null($ruleCondition->condition)) {
                                    $leadEvaluation[] = strtoupper($ruleCondition->condition);
                                }
                            }
                        } else {
                            // LEAD IS NOT MATCHING WITH RULE
                        }
                    }
                }

                $leadEve = implode(" ", $leadEvaluation);
                $leadEve2 = explode(" ", $leadEve);
                $lastWordInLeadEvaluation = $leadEve2[count($leadEve2) - 1];
                if ($lastWordInLeadEvaluation == "OR" || $lastWordInLeadEvaluation == "AND") {
                    $leadEve .= ' 0';
                }
                $leadValue = eval("return ($leadEve);");
                if ($leadValue) {
                    $leadMatchingRule[] = $leadId;
                }

            }

            $communicationSchedule = Communication::create([
                'type'=>$request->communicationTemplateType,
                'message'=>$request->communicationTemplateMessage,
                'subject'=>$request->communicationTemplateSubject,
                'content'=>$request->communicationTemplateBody,
                'schedule'=>'now',
                'words'=>'now',
                'template_id'=>$request->communicationTemplateId,
                'rule_id'=>$request->ruleId
            ]);

            if (!empty($leadMatchingRule)) {

                foreach ($leadMatchingRule as $key => $value) {
                    $employee=CommunicationLead::create([
                        'communication_id'=>$communicationSchedule->id,
                        'rule_id'=>$ruleId,
                        'lead_id'=>$value
                    ]);
                }

                if($request->communicationTemplateType == 'SMS') {
                    //SEND SMS HERE
                } else if ($request->communicationTemplateType == 'Email') {

                    $templateId = $request->communicationTemplateId;
                    $template = Template::where('id', $templateId)->first();

                    foreach ($leadMatchingRule as $key => $value) {
                        $lead = Lead::where('id', $value)->first();
                        //TODO Validate email
                        Log::info($lead->email);
                        if($lead->email) {
//                        Mail::to($lead->email)->send(new Campaign($lead->email));
                            Mail::to($lead->email)->send(new Campaign($template));
                        }
                    }

                } else if ($request->communicationTemplateType == 'WhatsApp') {
                    foreach ($leadMatchingRule as $key => $value) {
                        $lead = Lead::where('id', $value)->first();
                        //TODO Validate mobile
                        if($lead->mobileno) {
                            Notification::send($lead, new LeadConnect($lead));
                        }
                    }
                }

            }

//        return Command::SUCCESS;
        }

        $communications = Communication::all();
        return redirect()->route('communications.index', compact('communications'));

    }

    public function update(Request $request) : RedirectResponse {

        $id = $request->input('communicationId');
        $communication = Communication::where('id', $id)->get()->first();

        $communication->rule_id = $request->input('ruleId');
        $communication->type = $request->input('communicationTemplateType');
        $communication->template_id = $request->input('communicationTemplateId');
        $communication->subject = $request->input('communicationTemplateSubject');
        $communication->message = $request->input('communicationTemplateMessage');
        $communication->content = $request->input('communicationTemplateBody');
        $communication->schedule = $request->input('schedule');

        $communicationType = $request->input('schedule');
        $words = null;
        if ($communicationType == 'scheduled') {

            $scheduleUnit = $request->input('scheduleUnit');
            $dayOfWeek = $request->input('dayOfWeek');
            $dayOfMonth = $request->input('dayOfMonth');
            $minuteHour = $request->input('minuteHour');

            $schedule = null;

            if ($scheduleUnit == 'DAILY') {
                $dayOfWeek = "*";
                $dayOfMonth = "*";
            }

            if ($scheduleUnit == 'WEEKLY') {
                $dayOfMonth = "*";
            }

            if (!is_null($minuteHour)) {
                $hour = substr($minuteHour, 0, 2);
                $min = substr($minuteHour, 3, 2);
                $schedule = $min . ' ' . $hour . ' ' . $dayOfMonth . ' ' . '*' . ' ' . $dayOfWeek;
            }

            $words = CronTranslator::translate($schedule);
        } else if ($communicationType == 'now') {
            $words = 'now';
        }

        $communication->words = $words;

        $communication->save();

        $communications = Communication::all();
        return redirect()->route('communications.index', compact('communications'));

    }

    public function leads($id)
    {
        $communicationleads = CommunicationLead::where('communication_id',$id)->get();
        $leads = array();
        foreach ($communicationleads as $communicationlead) {
            Log::info($communicationlead);
            $leads[] = $communicationlead->lead_id;
        }
        $leads = Lead::wherein('id', array_values($leads))->get();
        return view('communications.leads', compact('leads'));
    }

    public function templates($id) : JsonResponse {

        $template = null;
        if ($id === 'Email' OR $id === 'WhatsApp') {
            $template = Template::where('type', $id)->get();
        } else {
            $template = Template::where('id', $id)->first();
        }

        return response()->json(['template' => $template, 'success' => 'Received template data']);
    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Communication::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
}
