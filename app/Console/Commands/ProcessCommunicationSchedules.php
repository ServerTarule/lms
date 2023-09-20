<?php

namespace App\Console\Commands;

use App\Mail\Campaign;
use App\Models\CommunicationLead;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\RuleCondition;
use App\Models\Template;
use App\Notifications\LeadConnect;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Channels\WaclubWhatsApp;
use Illuminate\Support\Facades\DB;
use App\Models\Rule;
class ProcessCommunicationSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'processcommunicationschedules:cron {communicationSchedule}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Communication Schedules';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {

        // Log::info("I am handling");
        $communicationSchedule = $this->argument('communicationSchedule');
        // Log::info("#############################START#############");
        // Log::info($communicationSchedule);
        // Log::info("#############################END#############");
        $communicationSchedule = json_decode($communicationSchedule, true);
        $ruleId = $communicationSchedule['rule_id'];
        // Log::info("*** Communication Schedule JSON Decode ***");
        // Log::info($communicationSchedule);
       
        $leadMatchingRuleOld = $this->getLeadMatchingRuleOld($ruleId);
        Log::info("*** leadMatchingRuleOld ***");
        Log::info($leadMatchingRuleOld);
        $leadMatchingRule = $this->getLeadMatchingRule($ruleId);

        Log::info(" ***********leadMatchingRuleNew***********");
        Log::info($leadMatchingRule);
        if (!empty($leadMatchingRule)) {
            Log::info("******leadMatchingRule is noot empty****");
            foreach ($leadMatchingRule as $key => $value) {
                $employee=CommunicationLead::create([
                    'communication_id'=>$communicationSchedule['id'],
                    'rule_id'=>$ruleId,
                    'lead_id'=>$value
                ]);
                Log::info("******Logging Employee ****");
                Log::info($employee);
            }
            Log::info("******type ****");
            Log::info($communicationSchedule['type']);
            if($communicationSchedule['type'] == 'SMS') {
                Log::info("******SMS condition ****");
                //SEND SMS HERE
            } else if ($communicationSchedule['type'] == 'Email') {
                Log::info("******Email condition ****");
                $templateId = $communicationSchedule['template_id'];
                $template = Template::where('id', $templateId)->first();

                foreach ($leadMatchingRule as $key => $value) {
                    $lead = Lead::where('id', $value)->first();
                    //TODO Validate email
                    
                    if($lead && $lead->email) {
                        Log::info($lead->email);
                        //."--------The Id is----".$communicationSchedule['id'];
                        $template->message = $communicationSchedule['content'];
                        $template->body = $communicationSchedule['content'];
                        $template->subject = $communicationSchedule['subject'];

                        Log::info("******Final Template Content Start****");
                        Log::info($template);
                        Log::info("******Final Template Content End****");

                        $mailableObj = new Campaign($template);
                        try{
                            Mail::to($lead->email)->send($mailableObj);
                        }
                        catch (Request $e) {
                            throw new \Exception($e->getMessage());
                        }
                    }
//                     if($lead->email) {
// //                        Mail::to($lead->email)->send(new Campaign($lead->email));
//                         Mail::to($lead->email)->send(new Campaign($template));
//                     }
                }

            } else if ($communicationSchedule['type'] == 'WhatsApp') {
                Log::info("******WhatsApp condition ****");
                echo '------Whatsapp leadMatchingRule found-------';
                foreach ($leadMatchingRule as $key => $value) {
                    Log::info("====value=====");
                    Log::info($value);
                    $lead = Lead::where('id', $value)->first();
                    //TODO Validate mobile
                    // if($lead->mobileno) {
                    //     Notification::send($lead, new LeadConnect($lead));
                    // }
                    Log::info("====lead=====");
                    Log::info($lead);

                   
                    if($lead && $lead->mobileno) {
                        Log::info("====mobileno=====");
                        Log::info($lead->mobileno);
                        $mobileNo = '+91'.$lead->mobileno;

                        Log::info("====final mobileNo=====");
                        Log::info($mobileNo);
                        $message = $communicationSchedule['message'];
                        Log::info("====final message=====");
                        Log::info($message);
                        try{
                            $response = WaclubWhatsApp::sendMessage($mobileNo,$message);
                        }
                        catch (Request $e) {
                            Log::info("====Exception Message for=====".$lead->id."=====");

                            Log::info($e->getMessage);
                            throw new \Exception($e->getMessage());
                        }
                    }
                }
                Log::info("******Done With WhatsApp condition ****");
            }

        }
       return Command::SUCCESS;
    }


    public function getDayCountForFrequency($ruleId) {
        $result = ["date"=>date('Y-m-d'),"count"=>0];
        $ruleData = Rule::find($ruleId);
        // Log::info("====ruleData=====");
        // Log::info($ruleData);
        $ruleFrequency = $ruleData->ruleFrequency ?? $ruleData->rulefrequency;
        $ruleSchedule = $ruleData->ruleSchedule ?? $ruleData->ruleschedule;
        $timeToReduceFromCurrentTime = $ruleFrequency." ".$ruleSchedule;
        $dateAtGivenFrequency= date('Y-m-d', strtotime("-$timeToReduceFromCurrentTime"));
        $today = date_create(date('Y-m-d'));
        $pastDate = date_create($dateAtGivenFrequency);
        $dateDiff = date_diff($today, $pastDate);
        $dateDiffCount = $dateDiff->days;
        $result["date"] = $dateAtGivenFrequency;
        $result["count"] = $dateDiffCount;
        // Log::info("====result=====");
        // Log::info($result);
        return $result;
    }
    public function getLeadMatchingRule($ruleId) {
        $dateDiffResult = $this->getDayCountForFrequency($ruleId);
        $dateDiffCount = $dateDiffResult["count"];
        $query = "SELECT id, DATEDIFF(CURDATE(), created_at) AS days,created_at FROM  leads where DATEDIFF(CURDATE(), created_at) = $dateDiffCount";
        $leadsWithDateCondotion = DB::select($query);
        Log::info("====query=====");
        Log::info($query);
        $dateCondtionSaisfyingLead = [];
        foreach($leadsWithDateCondotion as $leadWithDateCondotion) {
            $dateCondtionSaisfyingLead[] = $leadWithDateCondotion->id;
        }
       
        $ruleConditions = RuleCondition::where('rule_id', $ruleId)->orderBy('master_id', 'asc')->get();
        $leadIdsMatchingRuleCondition = array();
        
        // Log::info("====dateCondtionSaisfyingLead=====");
        // Log::info($dateCondtionSaisfyingLead);
        foreach ($ruleConditions as $ruleCondition) {
            $matchCase = ['master_id' => $ruleCondition->master_id, 'mastervalue_id' => $ruleCondition->mastervalue_id];
             
            $leadMastersMatchingRuleConditionMaster = LeadMaster::where($matchCase)->get();
            foreach ($leadMastersMatchingRuleConditionMaster as $leadMasterMatchingRuleConditionMaster) {
                $leadIdsMatchingRuleCondition[] = $leadMasterMatchingRuleConditionMaster->lead_id;
            }
        }
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
    function getLeadMatchingRuleOld($ruleId) {
        $dateDiffResult = $this->getDayCountForFrequency($ruleId);
        $dateDiffCount = $dateDiffResult["count"];
        $query = "SELECT id, DATEDIFF(CURDATE(), created_at) AS days,created_at FROM  leads where DATEDIFF(CURDATE(), created_at) = $dateDiffCount";
        $leadsWithDateCondotion = DB::select($query);
        Log::info("====query=====");
        Log::info($query);
        $dateCondtionSaisfyingLead = [];
        foreach($leadsWithDateCondotion as $leadWithDateCondotion) {
            $dateCondtionSaisfyingLead[] = $leadWithDateCondotion->id;
        }

        Log::info("I am dateCondtionSaisfyingLead ------");
        Log::info($dateCondtionSaisfyingLead);

        $ruleConditions = RuleCondition::where('rule_id', $ruleId)->orderBy('master_id', 'asc')->get();
        //Log::info("*** Rule Conditions ***");
        //Log::info($ruleConditions);
        $leadIdsMatchingRuleCondition = array();
        // Log::info("I am handling -----222-");
        // Log::info($ruleConditions);
        foreach ($ruleConditions as $ruleCondition) {
            $matchCase = ['master_id' => $ruleCondition->master_id, 'mastervalue_id' => $ruleCondition->mastervalue_id];
            $leadMastersMatchingRuleConditionMaster = LeadMaster::where($matchCase)->get();
            foreach ($leadMastersMatchingRuleConditionMaster as $leadMasterMatchingRuleConditionMaster) {
                $leadIdsMatchingRuleCondition[] = $leadMasterMatchingRuleConditionMaster->lead_id;
            }
        }
        $uniqueLeadIdsMatchingRuleCondition = collect($leadIdsMatchingRuleCondition)->unique();
        
        $leadMatchingRule = array();
        Log::info("I am uniqueLeadIdsMatchingRuleCondition ------");
        Log::info($uniqueLeadIdsMatchingRuleCondition);
        $leadIdsWithDateAndRuleConditions = array_intersect($dateCondtionSaisfyingLead,$uniqueLeadIdsMatchingRuleCondition->toArray());
        
        Log::info("I am intersect result i.e. leadIdsWithDateAndRuleConditions >>>>>------");
        Log::info($leadIdsWithDateAndRuleConditions);

        Log::info("Old Was >>>>>------");
        Log::info($uniqueLeadIdsMatchingRuleCondition);

        foreach ($leadIdsWithDateAndRuleConditions as $leadId) {
        // foreach ($uniqueLeadIdsMatchingRuleCondition as $leadId) {
            $leadMasters = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->orderBy('master_id', 'asc')->get();
            $leadMastersCount = count($leadMasters);
            //Log::info("*** Lead Master Count ***");
            //Log::info($leadMastersCount);
            $leadEvaluation = array();

            // Log::info("I am ruleConditions ------");
            // Log::info($ruleConditions);
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

            //  Log::info("*** Lead Evaluation ***");
            //  Log::info($leadEvaluation);
            $leadEve = implode(" ", $leadEvaluation);
            // Log::info("*** Lead Evaluation - Implode ***");
            //Log::info($leadEve);
            $leadEve2 = explode(" ", $leadEve);
            //Log::info("*** Lead Evaluation - Explode ***");
            //Log::info($leadEve2);

            $lastWordInLeadEvaluation = $leadEve2[count($leadEve2) - 1];
            //Log::info("*** Last word in lead evaluation ***");
            //Log::info($lastWordInLeadEvaluation);
            if ($lastWordInLeadEvaluation == "OR" || $lastWordInLeadEvaluation == "AND") {
                $leadEve .= ' 0';
            }
            //Log::info("*** Lead Evaluation - lead evaluation ***");
            //Log::info($leadEve);
            $leadValue = eval("return ($leadEve);");
            //Log::info("*** Lead Evaluation - lead value ***");
            //Log::info($leadValue);
            if ($leadValue) {
                $leadMatchingRule[] = $leadId;
            }
            //Log::info("*** Lead Evaluation - Matching leads ***");
            //Log::info($leadMatchingRule);
            return $leadMatchingRule;
        }
    }

}
