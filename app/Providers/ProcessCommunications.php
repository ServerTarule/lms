<?php
namespace App\Providers;


use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\LeadMaster;
use Illuminate\Support\Facades\DB;
class ProcessCommunicationService {

    public function getLeadMatchingRule($ruleId) {
        $ruleData = Rule::find($ruleId);
        $ruleFrequency = $ruleData->ruleFrequency;
        $ruleSchedule = $ruleData->ruleSchedule;
        $timeToReduceFromCurrentTime = $ruleFrequency." ".$ruleSchedule;
        $query = "SELECT id FROM  leads  WHERE  created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL $timeToReduceFromCurrentTime) AND CURDATE()";
        $leadsWithDateCondotion = DB::select($query);
        $dateCondtionSaisfyingLead = [];
        foreach($leadsWithDateCondotion as $leadWithDateCondotion) {
            $dateCondtionSaisfyingLead[] = $leadWithDateCondotion->id;
        }
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
 
    
}

?>
