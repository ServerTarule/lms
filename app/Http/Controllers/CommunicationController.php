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
use Illuminate\Support\Facades\DB;
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
        $rules = Rule::all()->where("ruletype",'=',"outbound");
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
        $ruleId = $request->ruleId;
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
            try{
                $ruleId = $request->ruleId;
                //Get Lead Matching With Rule
                
                $communicationSchedule = Communication::create([
                    'type'=>$request->communicationTemplateType,
                    'message'=>$request->communicationTemplateMessage,
                    'subject'=>$request->communicationTemplateSubject,
                    'content'=>$request->communicationTemplateBody,
                    'schedule'=>'now',
                    'schedule_unit' => '',
                    'words'=>'now',
                    'template_id'=>$request->communicationTemplateId,
                    'rule_id'=>$request->ruleId
                ]);
                $response = $this->sendNotification($ruleId,$request,$communicationSchedule);
                $ressultArray = json_decode($response,true);
                if(!$ressultArray['success']) {
                    throw new \Exception("Schedule saved into DB. But error occurred while sending WhatsApp message! ".$ressultArray['message']);
                }
               
            }
            catch (Request $e) {
                throw new \Exception($e->getMessage());
            }
        }
        return response()->json(['status'=>true, 'message'=>'Communication schedule has been processed successfully.']);
    }

    public function sendNotification($ruleId, $request, $communicationSchedule) {
        $leadMatchingRule = $this->getLeadMatchingRule($ruleId);
        if (!empty($leadMatchingRule)) {
            if($request->communicationTemplateType == 'SMS') {
                //SEND SMS HERE
            } else if ($request->communicationTemplateType == 'Email') {
                $templateId = $request->communicationTemplateId;
                $template = Template::where('id', $templateId)->first();
                foreach ($leadMatchingRule as $key => $value) {
                    $employee=CommunicationLead::create([
                        'communication_id'=>$communicationSchedule->id,
                        'rule_id'=>$ruleId,
                        'lead_id'=>$value
                    ]);
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
                                return response()->json(['status'=>false, 'message'=>`Communication schedule  has been saved successfully, and email has also been sent `]);
                            }
                            catch (Request $e) {
                                throw new \Exception('Communication schedule  has been saved successfully, But error occurred while sending email.');
                            }
                        }
                    }
                    else {
                        //In Case Error Occurred While Sending Email
                        return response()->error(['status'=>false, 'message'=>`Communication schedule  has been saved successfully, But email could not be sent `]);
                    }
                   
                }

            } else if ($request->communicationTemplateType == 'WhatsApp') {
                foreach ($leadMatchingRule as $key => $value) {
                    CommunicationLead::create([
                        'communication_id'=>$communicationSchedule->id,
                        'rule_id'=>$ruleId,
                        'lead_id'=>$value
                    ]);
                    $lead = Lead::where('id', $value)->first();
                    if($lead && $lead->mobileno) {                        
                        return WaclubWhatsApp::sendMessage('+91'.$lead->mobileno,$request->communicationTemplateMessage);
                    }
                }
            }

        }  
    }

    public function getDayCountForFrequency($ruleId) {
        $result = ["date"=>date('Y-m-d'),"count"=>0];
        //$ruleFrequency,$ruleSchedule
        
        $ruleData = Rule::find($ruleId);
        if($ruleData) {
            $ruleData = $ruleData->toArray();
            if(isset($ruleData["rulefrequency"])){
                $ruleFrequency = $ruleData["rulefrequency"];
            }
            else if(isset($ruleData["ruleFrequency"])) {
                $ruleFrequency = $ruleData["ruleFrequency"];
            }

            if(isset($ruleData["ruleschedule"])){
                $ruleSchedule = $ruleData["ruleschedule"];
            }
            else if(isset($ruleData["ruleSchedule"])) {
                $ruleSchedule = $ruleData["ruleSchedule"];
            }
            
            $timeToReduceFromCurrentTime = $ruleFrequency." ".$ruleSchedule;
            $dateAtGivenFrequency= date('Y-m-d', strtotime("-$timeToReduceFromCurrentTime"));
            // echo "\n dateAtGivenFrequency = ".$dateAtGivenFrequency;
            $today = date_create(date('Y-m-d'));
            // echo "\n today";
            // print_r($today);
            $pastDate = date_create($dateAtGivenFrequency);
            // echo "\n pastDate";
            // print_r($pastDate);
            $dateDiff = date_diff($today, $pastDate);
            // echo "\n date_diff == ";
            // print_r($dateDiff);
            $dateDiffCount = $dateDiff->days;
             // echo "\n dateDiffCount == ";
            // print_r($dateDiffCount);
            $result["date"] = $dateAtGivenFrequency;
            $result["count"] = $dateDiffCount;
        }
       
        return $result;
    }
    public function getLeadMatchingRule($ruleId) {
        $dateDiffResult = $this->getDayCountForFrequency($ruleId);
        $dateDiffCount = $dateDiffResult["count"];
        $query = "SELECT id, DATEDIFF(CURDATE(), updated_at) AS days,updated_at FROM  leads where DATEDIFF(CURDATE(), updated_at) = $dateDiffCount";
        // echo "\n Query =".$query;
        $leadsWithDateCondotion = DB::select($query);
        // echo "\n leadsWithDateCondotion =";
        // print_r($leadsWithDateCondotion);
        // echo "\n ^^^^^^";
        // die;

        $dateCondtionSaisfyingLead = [];
        foreach($leadsWithDateCondotion as $leadWithDateCondotion) {
            $dateCondtionSaisfyingLead[] = $leadWithDateCondotion->id;
        }
       
        $ruleConditions = RuleCondition::where('rule_id', $ruleId)->orderBy('master_id', 'asc')->get();
        $leadIdsMatchingRuleCondition = array();
        // echo "###############dateCondtionSaisfyingLead#########";
        // print_r($dateCondtionSaisfyingLead);
        // echo "########################";die;
        foreach ($ruleConditions as $ruleCondition) {
            $matchCase = ['master_id' => $ruleCondition->master_id, 'mastervalue_id' => $ruleCondition->mastervalue_id];
            // echo "Match Cases";
            // print_r($matchCase);
            $leadMastersMatchingRuleConditionMaster = LeadMaster::where($matchCase)->get();
            // print_r($leadMastersMatchingRuleConditionMaster->toArray());
            foreach ($leadMastersMatchingRuleConditionMaster as $leadMasterMatchingRuleConditionMaster) {
                $leadIdsMatchingRuleCondition[] = $leadMasterMatchingRuleConditionMaster->lead_id;
            }
        }
        // print_r($leadIdsMatchingRuleCondition);
        // die("hello there");
        $uniqueLeadIdsMatchingRuleCondition = collect($leadIdsMatchingRuleCondition)->unique();
        $leadMatchingRule = array();
        $leadIdsWithDateAndRuleConditions = array_intersect($dateCondtionSaisfyingLead,$uniqueLeadIdsMatchingRuleCondition->toArray());
        foreach ($leadIdsWithDateAndRuleConditions as $leadId) {
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
        return $leadMatchingRule;
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
        try{
            $ruleId = $request->input('ruleId');
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
                $communication->schedule = 'now';
                $words = 'now';
            }

            $communication->words = $words;

            $communication->save();
            if ($communicationType == 'now') {
                try{
                    $response = $this->sendNotification($ruleId,$request,$communication);
                    $ressultArray = json_decode($response,true);
                    if(!$ressultArray['success']) {
                        throw new \Exception("Schedule saved into DB. But error occurred while sending WhatsApp message! ".$ressultArray['message']);
                    }
                }
                catch (Request $e) {
                    throw new \Exception($e->getMessage());
                }
            }
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
