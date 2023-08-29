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

use App\Channels\WaclubWhatsApp;

class CommunicationController extends Controller
{
    public $scheduleUnitArray = [
        'DAILY'=>'Daily',
        'WEEKLY'=>'Weekly',
        'FORTNIGHTLY'=>'Fortnightly',
        'MONTHLY'=>'Monthly',
        'QUARTERLY'=>'Quarterly',
        'HALFYEARLY'=>'Half Yearly',
        'YEARLY'=>'Yearly',
    ];
    public $daysArray = [
        '1'=>'Monday',
        '2'=>'Tuesday',
        '3'=>'Wednesday',
        '4'=>'Thursday',
        '5'=>'Friday',
        '6'=>'Saturday',
        '0'=>'Sunday',
    ];
    public function index()
    {
        $rules = Rule::all();
        $templates = Template::all();
        $communications = Communication::all();
        $scheduleUnitArray = $this->scheduleUnitArray;
        $daysArray = $this->daysArray;
        return view('communications.index', compact('rules', 'templates', 'communications','scheduleUnitArray','daysArray'));
    }

    public function show($id) : JsonResponse {
        $communication = Communication::where('id', $id)->get()->first();

        $schedule = $communication->schedule;

        if(strtolower($schedule) !== 'now') {
            $scheduleArr = explode(" ",$schedule);
            // print_r($scheduleArr);
            $minute= $scheduleArr[0];
            $hour= $scheduleArr[1];


        }

        // die;
        return response()->json([
            'schedule' => $communication,
            'success' => 'Received rule data'
        ]);
    }

    public function store(Request $request) : JsonResponse {
        Log::info("*** Communication Request ***");
        Log::info($request);
        $communicationType = $request->schedule;
        $comType = $request->communicationTemplateBody;
        // echo "-----".$communicationTemplateBody = ($comType==='Email')?$request->communicationTemplateBody:'';
        // die;
        if ($communicationType == 'scheduled') {
            if(!$request->input('scheduleUnit')) {
                return response()->json(['status'=>false, 'message'=>'Please selet schedule unit, if you have opted for scheduled job.']);

            }
            $communicationTemplateType = $request->communicationTemplateType;
            $communicationTemplateId = $request->communicationTemplateId;
            $communicationTemplateMessage = $request->communicationTemplateMessage;
            $communicationTemplateSubject = $request->communicationTemplateSubject??"Email From CFL";
            $communicationTemplateBody = $request->communicationTemplateBody;
            $scheduleUnit = $request->scheduleUnit;
            $dayOfWeek = $request->dayOfWeek;
            $dayOfMonth = $request->dayOfMonth;
            $ruleId = $request->ruleId;
            $minuteHour = $request->minuteHour;
            $schedule = $this->getCronSchedule($scheduleUnit,$dayOfWeek,$dayOfMonth, $minuteHour);
            $words = CronTranslator::translate($schedule);
            $communicationSchedule = Communication::create([
                'type'=>$communicationTemplateType,
                'message'=>$communicationTemplateMessage,
                'subject'=>$communicationTemplateSubject,
                'content'=>$communicationTemplateBody,
                'schedule'=>$schedule,
                'schedule_unit' => $request->input('scheduleUnit')?$request->input('scheduleUnit'):'',
                'words'=>$words,
                'template_id'=>$communicationTemplateId,
                'rule_id'=>$ruleId
            ]);

            // print_r($communicationSchedule);die;
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
                'message'=>($comType==='WhatsApp')?$request->communicationTemplateMessage:'',
                'subject'=>($comType==='Email')?$request->communicationTemplateSubject:'',
                'content'=>($comType==='Email')?$request->communicationTemplateBody:'',
                'schedule'=>'now',
                'schedule_unit' => '',
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
                        if($lead) {
                            Log::info($lead->email);
                            if($lead->email) {
                                $template->message = $request->communicationTemplateBody;
                                $template->subject = $request->communicationTemplateSubject;
                                $mailableObj = new Campaign($template);
                                try{
                                    Mail::to($lead->email)->send($mailableObj);
                                }
                                catch (Request $e) {
                                    throw new \Exception($e->getMessage());
                                }
                            }
                        }
                        else {
                            //
                            // return response()->json(['status'=>false, 'message'=>`Communication schedule  has been saved successfully, But email could not be sent `]);
                        }
                       
                    }

                } else if ($request->communicationTemplateType == 'WhatsApp') {
                    foreach ($leadMatchingRule as $key => $value) {
                        $lead = Lead::where('id', $value)->first();
                        //TODO Validate mobile
                        if($lead && $lead->mobileno) {
                            try{
                                $response = WaclubWhatsApp::sendMessage("+918010078232",$request->communicationTemplateMessage);
                            }
                            catch (Request $e) {
                                throw new \Exception($e->getMessage());
                            }
                        }
                    }
                }

            }
        }
        $communications = Communication::all();
        return response()->json(['status'=>true, 'message'=>'Communication schedule  has been saved successfully.']);
    }


    public function getCronSchedule($scheduleUnit,$dayOfWeek,$dayOfMonth, $minuteHour) {
        $month="*";
        $schedule = null;
        if ($scheduleUnit == 'DAILY') {
            $dayOfWeek = "*";
            $dayOfMonth = "*";
        }

        if ($scheduleUnit == 'WEEKLY') {
            $dayOfMonth = "*";
        }

        if ($scheduleUnit == 'FORTNIGHTLY') {
            $dayOfWeek = "*";
            $dayOfMonth = "1,15";
            // 0 5 1,15 * * "commande"
        }

        if ($scheduleUnit == 'MONTHLY') {
            $dayOfWeek = "*";
        }

        if ($scheduleUnit == 'QUARTERLY') {
            $dayOfWeek = "*";
            $dayOfMonth = "1";
            $month="*/3";
        }

        if ($scheduleUnit == 'HALFYEARLY') {
            $dayOfWeek = "*";
            $dayOfMonth = "1";
            $month="*/6";
        }

        if ($scheduleUnit == 'YEARLY') {
            $dayOfWeek = "*";
            $dayOfMonth = "1";
            $month="1";
        }


        if (!is_null($minuteHour)) {
            $hour = substr($minuteHour, 0, 2);
            $min = substr($minuteHour, 3, 2);
            $schedule = $min . ' ' . $hour . ' ' . $dayOfMonth . ' ' . $month . ' ' . $dayOfWeek;
        }
        else {
            //for 12 oclock morning
            $schedule = 0 . ' ' . 0 . ' ' . $dayOfMonth . ' ' . '*' . ' ' . $dayOfWeek;
        }
        return $schedule;
    }

    public function update(Request $request) : JsonResponse {
        // "WhatsApp"
// die($request->input('communicationTemplateType'));
        try{
            $id = $request->input('communicationId');
            $communication = Communication::where('id', $id)->get()->first();
            $communication->rule_id = $request->input('ruleId');
            $communication->type = $request->input('communicationTemplateType');
            $communication->template_id = $request->input('communicationTemplateId');
            $communication->subject = ($request->input('communicationTemplateType')==='Email')?$request->input('communicationTemplateSubject'):'';
            $communication->message = ($request->input('communicationTemplateType')==='WhatsApp')?$request->input('communicationTemplateMessage'):'';
            $communication->content = ($request->input('communicationTemplateType')==='Email')?$request->input('communicationTemplateBody'):'';
            $communication->schedule_unit = $request->input('scheduleUnit')?$request->input('scheduleUnit'):'';
            $communicationType = $request->input('schedule');
            $words = null;
            if ($communicationType == 'scheduled') {
                $scheduleUnit = $request->input('scheduleUnit');
                $dayOfWeek = $request->input('dayOfWeek');
                $dayOfMonth = $request->input('dayOfMonth');
                $minuteHour = $request->input('minuteHour');
                $schedule = $this->getCronSchedule($scheduleUnit,$dayOfWeek,$dayOfMonth, $minuteHour);
                $communication->schedule = $schedule;
                $words = CronTranslator::translate($schedule);

                // print("Traslated time");
                // print_r($words);

                // die("----hello----");
            } else if ($communicationType == 'now') {
                // $communication->frequency_expression = "";
                $communication->schedule = 'now';
                $words = 'now';
            }

            $communication->words = $words;

            $communication->save();

            $communications = Communication::all();
            return response()->json(['status'=>true, 'message'=>'Communication schedule  has been saved successfully.']);
        }
        catch (Request $e) {
            throw new \Exception($e->getMessage());
        }

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
