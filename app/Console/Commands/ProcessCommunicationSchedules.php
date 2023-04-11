<?php

namespace App\Console\Commands;

use App\Models\Communication;
use App\Models\CommunicationLead;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use function Sodium\randombytes_uniform;

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
    public function handle()
    {
        $communicationSchedule = $this->argument('communicationSchedule');
        $communicationSchedule = json_decode($communicationSchedule, true);
//        Log::info("*** Communication Schedule ***");
//        Log::info($communicationSchedule);

        $ruleId = $communicationSchedule['rule_id'];
        $ruleConditions = RuleCondition::where('rule_id', $ruleId)->orderBy('master_id', 'asc')->get();
//        Log::info("*** Rule Conditions ***");
//        Log::info($ruleConditions);

        $leadIdsMatchingRuleCondition = array();
        foreach ($ruleConditions as $ruleCondition) {
            $matchCase = ['master_id' => $ruleCondition->master_id, 'mastervalue_id' => $ruleCondition->mastervalue_id];
            $leadMastersMatchingRuleConditionMaster = LeadMaster::where($matchCase)->get();
            foreach ($leadMastersMatchingRuleConditionMaster as $leadMasterMatchingRuleConditionMaster) {
                $leadIdsMatchingRuleCondition[] = $leadMasterMatchingRuleConditionMaster->lead_id;
            }
        }

        $uniqueLeadIdsMatchingRuleCondition = collect($leadIdsMatchingRuleCondition)->unique();
//        Log::info("*** Unique Leads Ids ***");
//        Log::info($uniqueLeadIdsMatchingRuleCondition);

        $leadMatchingRule = array();
        foreach ($uniqueLeadIdsMatchingRuleCondition as $leadId) {
            $leadMasters = LeadMaster::where('lead_id', $leadId)->where('mastervalue_id', '<>', null)->orderBy('master_id', 'asc')->get();
            $leadMastersCount = count($leadMasters);
//            Log::info("*** Lead Master Count ***");
//            Log::info($leadMastersCount);
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

//            Log::info("*** Lead Evaluation ***");
//            Log::info($leadEvaluation);
            $leadEve = implode(" ", $leadEvaluation);
//            Log::info("*** Lead Evaluation - Implode ***");
//            Log::info($leadEve);
            $leadEve2 = explode(" ", $leadEve);
//            Log::info("*** Lead Evaluation - Explode ***");
//            Log::info($leadEve2);

            $lastWordInLeadEvaluation = $leadEve2[count($leadEve2) - 1];
//            Log::info("*** Last word in lead evaluation ***");
//            Log::info($lastWordInLeadEvaluation);
            if ($lastWordInLeadEvaluation == "OR" || $lastWordInLeadEvaluation == "AND") {
                $leadEve .= ' 0';
            }
//            Log::info("*** Lead Evaluation - lead evaluation ***");
//            Log::info($leadEve);
            $leadValue = eval("return ($leadEve);");
//            Log::info("*** Lead Evaluation - lead value ***");
//            Log::info($leadValue);
            if ($leadValue) {
                $leadMatchingRule[] = $leadId;
            }
//            Log::info("*** Lead Evaluation - Matching leads ***");
//            Log::info($leadMatchingRule);

        }

        if (!empty($leadMatchingRule)) {

            foreach ($leadMatchingRule as $key => $value) {
                $employee=CommunicationLead::create([
                    'communication_id'=>$communicationSchedule['id'],
                    'rule_id'=>$ruleId,
                    'lead_id'=>$value
                ]);
            }

            if($communicationSchedule['type'] == 'SMS') {
                //SEND SMS HERE
            } else if ($communicationSchedule['type'] == 'Email') {
                //SEND EMAIL HERE
            } else if ($communicationSchedule['type'] == 'WhatsApp') {
                //SEND WHATSAPP HERE
            }

        }
//        return Command::SUCCESS;
    }
}
