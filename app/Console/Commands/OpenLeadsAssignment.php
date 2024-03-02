<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\EmployeeRule;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\RuleCondition;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Leaves;
use App\Models\GlobalSetting;
use Illuminate\Support\Facades\DB;
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
    public function handle()
    {

        
        Log::info('*** Running new code ***');
        //New Code
        $set = GlobalSetting::all()->where('setting_key', '=','LEAD_ACCEPTANCE_INTERVAL');
        
        Log::info('*** $set ***');
        Log::info($set);
        $intervalSetting = $set;
        Log::info($intervalSetting);
        if(isset($intervalSetting) && count($intervalSetting) > 0) {
            $timeint = $intervalSetting[0]["setting_value"];
        }
        Log::info('*** $timeint ***');
        Log::info($timeint);
        $query = "SELECT l.*, NOW() as now, TIMESTAMPDIFF(MINUTE, updated_at, NOW()) as difdinminute FROM leads as l where is_accepted = 0 && TIMESTAMPDIFF(MINUTE, updated_at, NOW()) >= $timeint";
        // $query = "SELECT *  FROM  leads where TIMEDIFF(CURDATE(), updated_at) <= $timeint";
        // echo "\n Query =".$query;
        Log::info('*** $query ***');
        Log::info($query);

        $openLeads = DB::select($query);
        
        Log::info('*** $openLeads new logic ***');
        Log::info($openLeads);


        // $openLeads = Lead::where('is_accepted', 0)->get(); //Old Logic
        Log::info('*** open leads start ***');
        Log::info($openLeads);
        Log::info('*** open leads end ***');
        foreach ($openLeads as $openLead) {
            $alreadyAssignedEmployee = $openLead->employee_id;
            $lead = $openLead;
            $leadId = $lead->id;
            //For a lead, lead master is created with all masters
            //For a lead, get only those lead master records where master has value
            $leadMasters = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->orderBy('master_id', 'asc')->get();
            //Create a lead master KV for master and value
            $leadMasterKV = array();
            foreach ($leadMasters as $lm) {
                $leadMasterKV[$lm->master_id] = $lm->mastervalue_id;
            }
            //Identify Rule Conditions matching master and value present in lead
            $ruleIdsMatchingLeadMaster = array();
            foreach ($leadMasters as $leadMaster) {
                $matchCase = ['master_id' => $leadMaster->master_id, 'mastervalue_id' => $leadMaster->mastervalue_id];
                $ruleConditionsMatchingWithMasters = RuleCondition::where($matchCase)->get();
                foreach ($ruleConditionsMatchingWithMasters as $ruleConditionMatchingWithMasters) {
                    $ruleIdsMatchingLeadMaster[] = $ruleConditionMatchingWithMasters->rule_id;
                }
            }
            //Identified unique rule conditions matching master and value present in lead
            $uniqueRuleIdsMatchingLeadMaster = collect($ruleIdsMatchingLeadMaster)->unique();
            $ruleMatchingLeadMaster = array();
            foreach ($uniqueRuleIdsMatchingLeadMaster as $ruleId) {
                $ruleConditions = RuleCondition::where('rule_id', $ruleId)->get();
                $ruleConditionsCount = count($ruleConditions);
                $ruleEvaluation = array();
                $i = 0;
                foreach ($ruleConditions as $ruleCondition) {
                    foreach ($leadMasterKV as $key => $value) {
                        if ($ruleCondition->master_id == $key && $ruleCondition->mastervalue_id == $value) {
                            if ($ruleConditionsCount == 1) {
                                $ruleEvaluation[] = true;
                                break;
                            } else {
                                //MORE THAN 1 RULE CONDITION
                                $ruleEvaluation[] = true;
                                if (!is_null($ruleCondition->condition)) {
                                    $ruleEvaluation[] = strtoupper($ruleCondition->condition);
                                }
                            }
                        }
                    }
                }
                Log::info('*** Rule Evaluation ***');
                Log::info($ruleEvaluation);
                $ruleEve = implode(" ", $ruleEvaluation);
                $ruleEve2 = explode(" ", $ruleEve);
                $lastWordInRuleEvaluation = $ruleEve2[count($ruleEve2) - 1];
                if ($lastWordInRuleEvaluation == "OR" || $lastWordInRuleEvaluation == "AND") {
                    $ruleEve .= ' 0';
                }
                $ruleValue = eval("return ($ruleEve);");
                if ($ruleValue) {
                    $ruleMatchingLeadMaster[] = $ruleId;
                }
            }
            Log::info('***  ruleMatchingLeadMaster ***');
            Log::info($ruleMatchingLeadMaster);
            $employeeRules = EmployeeRule::wherein('rule_id', array_values($ruleMatchingLeadMaster))->where('status', 'true')->get();
            if($alreadyAssignedEmployee) {
                $employeeRules = EmployeeRule::wherein('rule_id', array_values($ruleMatchingLeadMaster))->where('status', 'true')->where('employee_id','!=', $alreadyAssignedEmployee )->get();
            }
            
            Log::info('***  employeeRules ***');
            Log::info($employeeRules);
            foreach ($employeeRules as $employeeRule) {
                $currentDateTime = date('Y-m-d H:i:s');
                //Write logic here for leaves....if employee is on leave when assignment is going on then loop will continue and pick other employee
                $employeeLeaves = Leaves::where('start_time','<=', $currentDateTime)->where('end_time','>=', $currentDateTime)->where('employee_id','=', $employeeRule->employee_id)->get();
                Log::info('*** employeeLeaves start ***');
                Log::info($employeeLeaves);
                Log::info('*** employeeLeaves end ***');
                if(count($employeeLeaves) > 0) {
                    continue;
                }
                Lead::where('id', $lead->id)->update(['employee_id' => $employeeRule->employee_id]);
                // $date = date('Y-m-d\TH:i:s.uP', time());
                Employee::where('id', $employeeRule->employee_id)->update(['lead_assigned_at' => $currentDateTime]);
            }
        }

        //Old Code
        // Log::info("CRON JOB - I am being called every minute asdasdasdasdasdas");
        // Log::info("CRON JOB - Open Leads Assignment");
        // $openLeads = Lead::whereNull('employee_id')->get();
        // Log::info($openLeads);
        // foreach ($openLeads as $openLead) {
        //     $employee = Employee::orderBy('lead_assigned_at', 'ASC')->first();
        //     $employeeId = $employee->id;

        //     Lead::where('id', $openLead->id)->update(['employee_id' => $employeeId]);
        //     $date = date('Y-m-d H:i:s');//'2023-08-13 20:12:33';//date('Y-m-d\TH:i:s.uP', time());
        //     Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);
        // }
    }
}
