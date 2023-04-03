<?php

namespace App\Listeners;

use App\Events\LeadReceived;
use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Employee;
use App\Models\EmployeeRule;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class AssignLead
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\LeadReceived $event
     * @return void
     */
    public function handle(LeadReceived $event): void
    {

        $lead = $event->lead;
        $leadId = $lead->id;

//        Log::info('*** Lead ***');
//        Log::info($leadId);

        $leadMasters = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->orderBy('master_id', 'asc')->get();
//        Log::info("**** Lead Masters - Master Values ****");
//        Log::info($leadMasters);

        $leadMasterKV = array();
        foreach ($leadMasters as $lm) {
            $leadMasterKV[$lm->master_id] = $lm->mastervalue_id;
        }
//        Log::info("**** Lead Masters - Master Values ****");
//        Log::info($leadMasterKV);

        $ruleIdsMatchingLeadMaster = array();
        foreach ($leadMasters as $leadMaster) {
            $matchCase = ['master_id' => $leadMaster->master_id, 'mastervalue_id' => $leadMaster->mastervalue_id];
            $ruleConditionsMatchingWithMasters = RuleCondition::where($matchCase)->get();
            foreach ($ruleConditionsMatchingWithMasters as $ruleConditionMatchingWithMasters) {
                $ruleIdsMatchingLeadMaster[] = $ruleConditionMatchingWithMasters->rule_id;
            }
        }

        $uniqueRuleIdsMatchingLeadMaster = collect($ruleIdsMatchingLeadMaster)->unique();
//        Log::info($uniqueRuleIdsMatchingLeadMaster);

        $ruleMatchingLeadMaster = array();
        foreach ($uniqueRuleIdsMatchingLeadMaster as $ruleId) {
            $ruleConditions = RuleCondition::where('rule_id', $ruleId)->get();
            $ruleConditionsCount = count($ruleConditions);
//            Log::info($ruleConditionsCount);
//            Log::info($ruleConditions);
            $ruleEvaluation = array();
            $i = 0;
            foreach ($ruleConditions as $ruleCondition) {
                $i++;
//                $ruleEvaluation = array();
//                Log::info($ruleCondition);
                foreach ($leadMasterKV as $key => $value) {
//                    Log::info("Key: " . $key . " Value: " . $value);
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
                    } else {
//                        //NO RULE CONDITION MATCH
//                        $ruleEligible[] = 'FALSE';
//                        $ruleEligible[] = 'NA';
                    }
                }
            }
//            Log::info('*** Rule Evaluation ***');
            $ruleEve = implode(" ", $ruleEvaluation);
            $ruleEve2 = explode(" ", $ruleEve);
//            Log::info($ruleEve);
            $lastWordInRuleEvaluation = $ruleEve2[count($ruleEve2) - 1];
            if ($lastWordInRuleEvaluation == "OR" || $lastWordInRuleEvaluation == "AND") {
                $ruleEve .= ' 0';
            }
//            Log::info($ruleEve);
            $ruleValue = eval("return ($ruleEve);");
            if ($ruleValue) {
                $ruleMatchingLeadMaster[] = $ruleId;
            }
//            Log::info('RuleValue: ' . $ruleValue);
        }

//        Log::info('*** Lead Applicable Rules ***');
//        Log::info(array_values($ruleMatchingLeadMaster));

        $employeeRules = EmployeeRule::wherein('rule_id', array_values($ruleMatchingLeadMaster))->where('status', 'true')->get();
        foreach ($employeeRules as $employeeRule) {
            Lead::where('id', $lead->id)->update(['employee_id' => $employeeRule->employee_id]);
            $date = date('Y-m-d\TH:i:s.uP', time());
            Employee::where('id', $employeeRule->employee_id)->update(['lead_assigned_at' => $date]);
        }

//        foreach ($ruleConditionsMatchingLeadMaster as $ruleConditionMatchingLeadMaster) {
//            Log::info($ruleConditionMatchingLeadMaster);
//
//            foreach ($leadMasterKV as $k => $v) {
//                if ($ruleConditionMatchingLeadMaster->master_id)
//            }
//
//            foreach ($leadMasterKV as $k => $v) {
//                Log::info('Master: ' . $k . ' , MasterValue: ' . $v);
//                foreach ($leadEligibleRuleConditions as $ruleCondition) {
////                    $matchCase = ['rule_id' => $value, 'master_id' => $k, 'mastervalue_id' => $v];
//                    $matchCase = ['rule_id' => $value];
//                    Log::info('*** Match Case ***');
//                    Log::info($matchCase);
//                    Log::info('*** Rule Condition matching with Match Case ***');
//                    $rc = RuleCondition::where($matchCase)->first();
//                    Log::info($rc);
//                    if (!is_null($rc)) {
////                        $condition = $rc->condition;
//                        Log::info(true . ' ' . null);
//                        if (!is_null($rc->condition)) {
////                            $rcMatch[true] = $rc->condition;
//                            Log::info(true . ' ' . $rc->condition);
//                        } else {
//                            Log::info(true . ' ' . null);
//                        }
//                    } else {
//                        Log::info();
//                    }
//                }
//            }
//
//        }
//

//        $leadApplicableRules = array();
//        $leadEligibleRuleConditionsParkedForEvaluations = [];

//        foreach ($leadMasters as $leadMaster) {
//            Log::info("\n");
//            Log::info('*** Lead Master ***');
//            Log::info($leadMaster);
//            $match = ['master_id' => $leadMaster->master_id, 'mastervalue_id' => $leadMaster->mastervalue_id];
//            $ruleConditions = RuleCondition::where($match)->rule();
//
//            Log::info('*** Matching Rule Conditions ***');
//            foreach ($ruleConditions as $ruleCondition) {
//                Log::info($ruleCondition);
//                if (is_null($ruleCondition->condition)) {
//                    $ruleConditionCount = RuleCondition::where('rule_id', $ruleCondition->rule_id)->count();
//                    if ($ruleConditionCount == 1) {
//                        $leadApplicableRules = $ruleCondition->rule_id;
//                    }
//                } else {
//
//                }
//            }
//
//        }

//
//        // For a lead, get list of all masters and master values
//
//        $leadMaster = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->get();
//        $leadMasterKV = array();
//        foreach ($leadMaster as $lm) {
//            $leadMasterKV[$lm->master_id] = $lm->mastervalue_id;
//        }
//        Log::info("**** Lead Masters - Master Values ****");
//        Log::info($leadMasterKV);
//
//        /*****/
//        //Get all rule conditions where master from lead is present
////        $ruleConditions = RuleCondition::wherein('master_id', array_keys($leadMasterKV))->get();
////        Log::info('*** Keys');
////        Log::info($ruleConditions);
////        foreach ($leadMasterKV as $key => $value) {
////            Log::info('*** Keys');
////        }
//
//        //Get all rule conditions where master values from a lead are present
//        //Even though a rule accepts multiple master values in a master. Assumption is lead will have only one master value per master
//        $ruleConditions = RuleCondition::wherein('mastervalue_id', array_values($leadMasterKV))->get();
//        Log::info('*** Rule Conditions matching Lead Master Values ***');
//        Log::info($ruleConditions);
////        foreach ($leadMasterKV as $key => $value) {
////            Log::info('*** Keys');
////        }
//
//        $leadEligibleRules = array();
//        foreach ($ruleConditions as $rc) {
//            $leadEligibleRules[] = $rc->rule_id;
//        }
//        Log::info('*** Rules Eligible basis matching Lead Master Values ***');
//        Log::info($leadEligibleRules);
//
//        foreach ($leadEligibleRules as $key => $value) {
//
//            $leadEligibleRuleConditions = RuleCondition::where('rule_id', $value)->get();
//
//            Log::info('*** All Rules Conditions for a Rule Id ***');
//            Log::info(count($leadEligibleRuleConditions));
//            Log::info($leadEligibleRuleConditions);
//
//            $rcMatch = array();
//            $rcMatchCondition = array();
//            foreach ($leadMasterKV as $k => $v) {
//                Log::info('Master: ' . $k . ' , MasterValue: ' . $v);
//                foreach ($leadEligibleRuleConditions as $ruleCondition) {
////                    $matchCase = ['rule_id' => $value, 'master_id' => $k, 'mastervalue_id' => $v];
//                    $matchCase = ['rule_id' => $value];
//                    Log::info('*** Match Case ***');
//                    Log::info($matchCase);
//                    Log::info('*** Rule Condition matching with Match Case ***');
//                    $rc = RuleCondition::where($matchCase)->first();
//                    Log::info($rc);
//                    if (!is_null($rc)) {
////                        $condition = $rc->condition;
//                        Log::info(true . ' ' . null);
//                        if (!is_null($rc->condition)) {
////                            $rcMatch[true] = $rc->condition;
//                            Log::info(true . ' ' . $rc->condition);
//                        } else {
//                            Log::info(true . ' ' . null);
//                        }
//                    } else {
//                        Log::info();
//                    }
//                }
//            }
//
//            Log::info($rcMatch);
//
//        }

        /*
        Log::info('\n *** Working');
        $employee = Employee::orderBy('lead_assigned_at', 'ASC')->first();
        $employeeId = $employee->id;
        //Get list of rules, where Master from lead is present as Master in rule
        $ruleConditionKV = array();
        $ruleConditions = RuleCondition::wherein('master_id', array_keys($leadMasterKV))->get(); //Rule order can be added
        Log::info($ruleConditions);
        foreach ($ruleConditions as $ruleCondition) {
            $ruleConditionKV[$ruleCondition->rule_id] = $ruleCondition->master_id;
            //Can be written to get master and master value
        }
        Log::info($ruleConditionKV);

        $employeeRules = EmployeeRule::wherein('rule_id', array_keys($ruleConditionKV))->where('status','true')->get();

        $employeeRules = json_decode($employeeRules, true);
        Log::info($employeeRules);
        foreach ($employeeRules as $employeeRule) {
            Log::info('Employee Id: ' . $employeeRule['employee_id']);
            Log::info('Lead Id: ' . $leadId);
            $leadTBU = Lead::where('id', $leadId)->update(['employee_id' => $employeeRule['employee_id']]);
            $date = date('Y-m-d\TH:i:s.uP', time());
            Employee::where('id', $employeeRule['employee_id'])->update(['lead_assigned_at' => $date]);
        }
        Log::info('\n *** Working');
        */

//        Lead::where('id', $leadId)->update(['employee_id' => $employeeId]);
//        $date = date('Y-m-d\TH:i:s.uP', time());
//        Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);

//        $ruleConditionKV = array();
//        foreach ($leadMasterKV as $key => $value) {
//            $ruleConditionKV[$key] = RuleCondition::where('master_id', $key)->get()->rule_id;
//        }
//        Log::info($ruleConditionKV);


        /*

        //Get Lead Master using Lead

        $leadMaster = LeadMaster::where('lead_id', $lead->id);

        //Check if State is present in Lead
        $stateMasterId = DynamicMain::where('name', 'States')->first()->id;
        //Check if the State with id is present in Lead
        $leadStateId = LeadMaster::where('master_id', $stateMasterId)->orderBy('id','DESC')->first()->master_id;

        if(!is_null($leadStateId)) {

            //Find all rules where State is present
            $ruleConditionsWithStates = RuleCondition::where('master_id', $stateMasterId)->get();
            //Find all employees where Rule having State is present
            $employeesWithRuleWithState = [];

            foreach ($ruleConditionsWithStates as $ruleConditionWithStates) {
                $employeeRulesWithState = EmployeeRule::where('rule_id', $ruleConditionWithStates->rule_id)->get();
                foreach ($employeeRulesWithState as $employeeRuleWithState) {
                    array_push($employeesWithRuleWithState, $employeeRuleWithState);
                }
            }

            Log::info($employeesWithRuleWithState);

            foreach ($employeesWithRuleWithState as $employeeRule) {
                Lead::where('id', $lead->id)->update(['employee_id' => $employeeId]);
                $date = date('Y-m-d\TH:i:s.uP', time());
                Employee::where('id', $employeeRule->employee_id)->update(['lead_assigned_at' => $date]);
            }

        }
*/


        //All leads coming from Whatsapp/email will get assigned to Agent A

        //All leads having location as Pune will get assigned to Agent B

        //On every Sunday/Holiday from 9 AM till 12 PM all fresh leads will be assigned to Agent A AND 12 PM to 3 PM all fresh leads will be assigned to Agent B AND 3 PM till 6 PM all fresh leads will be assigned to Agent C

        //SuperHot leads should always be in the top of the queue followed by Hot, Warm and Cold

    }

    /**
     * Handle a job failure.
     */
    public function failed(LeadReceived $event, Throwable $exception): void
    {
        // ...
    }
}
