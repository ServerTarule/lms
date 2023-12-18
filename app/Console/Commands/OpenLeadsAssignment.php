<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadAssignmentQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\RuleCondition;
use App\Models\LeadMaster;
use App\Models\Rule;
class OpenLeadsAssignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openleadsassignment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open Leads Assignment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handleOld()
    {
        Log::info("CRON JOB - I am being called every minute, to assign a lead to employee.");
        Log::info("CRON JOB - Open Leads Assignment");
        $openLeads = Lead::whereNull('employee_id')->get();
        Log::info($openLeads);
        foreach ($openLeads as $openLead) {
            $employee = Employee::orderBy('lead_assigned_at', 'ASC')->first();
            $employeeId = $employee->id;

            Lead::where('id', $openLead->id)->update(['employee_id' => $employeeId]);
            $date = date('Y-m-d H:i:s');
            //'2023-08-13 20:12:33';//date('Y-m-d\TH:i:s.uP', time());
            Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);
        }
    }

    public function handle()
    {
        Log::info("CRON JOB - I am being called every minute, to assign a lead to employee.");
        Log::info("CRON JOB - Open Leads Assignment");
        //Get All un-assigned lead
        $openLeads = Lead::whereNull('employee_id')->get();
        Log::info($openLeads);
        $employees = $this->getEmployeesWhoAreNotOnLeave();
        // foreach ($openLeads as $openLead) {
        //     $employee = Employee::orderBy('lead_assigned_at', 'ASC')->first();
        //     $employeeId = $employee->id;
            
        //     Lead::where('id', $openLead->id)->update(['employee_id' => $employeeId]);
        //     $date = date('Y-m-d H:i:s');
        //     //'2023-08-13 20:12:33';//date('Y-m-d\TH:i:s.uP', time());
        //     Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);
        // }
    }
    private function getEmployeesWhoAreNotOnLeave() {
        $query = "SELECT * FROM `leaves` WHERE start_time <=  CURRENT_TIMESTAMP AND end_time >= CURRENT_TIMESTAMP";
        $employeesOnLeaveNow = DB::select($query);
        // print_r($employeesOnLeaveNow);
        Log::notice("---employeesOnLeaveNow----",$employeesOnLeaveNow);
        $employeesOnLeave = array();
        foreach($employeesOnLeaveNow as $employee) {
            array_push($employeesOnLeave,$employee->employee_id);
        }
        Log::notice("*****employeesOnLeave****",$employeesOnLeave);
        //info($employeesOnLeave);
        $employeesOnLeaveStr = implode(",",$employeesOnLeave);
        $queryToGetEMployee = "SELECT * FROM `employees` WHERE lead_assigned_at IS NULL and id NOT IN ($employeesOnLeaveStr) ";
        Log::notice("****queryToGetEMployee****",[$queryToGetEMployee]);
        $employeesWithoutLead = DB::select($queryToGetEMployee);
        // $employeesWithoutLead1 = DB::selectOne($queryToGetEMployee);
        Log::notice("****employeesWithoutLead****",$employeesWithoutLead);
        $resultArray = json_decode(json_encode($employeesWithoutLead), true);
        Log::notice("****resultArray****",$resultArray);
        // Log::info("*************************************************");
        // Log::info($employeesWithoutLead1);
        // Log::info("---count---",count($employeesWithoutLead));
        foreach($resultArray  as $empWithoutLead ) {
            Log::notice("INside loop");
            Log::notice("******empWithoutLead******",$empWithoutLead);
            Log::notice("INside loop end");
            // Log::info($employeeWithoutLead);
            $employeeId = $empWithoutLead['id'];
            Log::notice("******Rules for employeee id******* : $employeeId-----");
            $queryToGetEMployeeRules = "SELECT * FROM `employeerules` WHERE employee_id = '$employeeId'";
            Log::notice("******queryToGetEMployeeRules******",[$queryToGetEMployeeRules]);
            $employeeRules = DB::select($queryToGetEMployeeRules);
            if($employeeRules) {
                // $employeeRulesArray = json_decode(json_encode($employeeRules), true);
                Log::notice("******employeeRules******");
                Log::notice("******employeeRules******",$employeeRules);
                foreach($employeeRules as $employeeRule) {
                    $ruleId = $employeeRule->rule_id;
                    Log::notice("******employeeRule one object******",[$employeeRule->rule_id]);
                    // $ruleId = $employeeRule['rule_id'];
                    // Log::notice("******employeeRules******",[$ruleId]);
                    $leadMatchingRule = $this->getLeadMatchingRule($ruleId);
                    Log::notice("******All Lead Matching Rule for role id *****>$ruleId<**** and employee id   *****>$employeeId<**********",$leadMatchingRule);
                    $this->createQueeToAssignLeadToEmployee($employeeId, $leadMatchingRule);
                }
            }
        }
        return $employeesOnLeaveNow;
    }
    
    public function createQueeToAssignLeadToEmployee($employeeId, $leadMatchingRule){
        $leadAssignmentQueueData = array();
        foreach($leadMatchingRule as $lead) {
            $assignmentArray= array(
                'lead_id'=>$lead,
                'employee_id'=>$employeeId,
                'is_approved'=>false
            );
            
            // $checkIfDataAlreadyExists = "SELECT from";
            //$leadInQueue = LeadAssignmentQueue::where('lead_id',$lead)->where('employee_id',$employeeId)->get();
            
            $leadQueueQuery = "SELECT * FROM  lead_assignment_queues where `lead_id`  = $lead and `employee_id` = $employeeId";
            $leadInQueue = DB::select($leadQueueQuery);
            Log::notice("******going to check not isset leadInQueue----leadQueueQuery: $leadQueueQuery-----******",[]);
            if(empty($leadInQueue) || !$leadInQueue || !isset($leadInQueue)) {
                Log::notice("******leadInQueue******",$leadInQueue);
                $leadAssignmentQueueData [] = $assignmentArray;
            }
            else {
                Log::notice("******No lead to sve InQueue******",[]);
                continue;
            }
        }
        Log::notice("******lead assignment queue data to create******",$leadAssignmentQueueData);
        DB::table('lead_assignment_queues')->insert($leadAssignmentQueueData);
    }

    public function getLeadMatchingRule($ruleId) {
        Log::notice("====Getting Matching Lead For Rule Id $ruleId=====",[]);
        $dateDiffResult = $this->getDayCountForFrequency($ruleId);
        Log::notice("====dateDiffResult=====",$dateDiffResult);
        $dateDiffCount = $dateDiffResult["count"];
        Log::notice("====dateDiffCount=====",[$dateDiffCount]);
        //$openLeads = Lead::whereNull('employee_id')->get();
        $queryOpenLeads = "SELECT id FROM  leads where employee_id IS NULL";
        $openLeads = DB::select($queryOpenLeads);
        Log::info("====query open lead $queryOpenLeads=====");
        // Log::info($queryOpenLeads);
        $openLeadIds = [];
        foreach($openLeads as $openLead) {
            $openLeadIds[] = $openLead->id;
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
        $leadIdsWithDateAndRuleConditions = array_intersect($openLeadIds,$uniqueLeadIdsMatchingRuleCondition->toArray());
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
}
