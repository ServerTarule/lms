<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\Rule;
use App\Models\RuleCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\Console\Input\Input;
use function Sodium\add;

class ConditionsController extends Controller
{
    public function create(Request $request) : View {
        $data = $request->query('data');
        $ruleName = $request->query('ruleName');
        // print_r($data );die;
        $masters =[];
        if($data) {
            $masters = DynamicMain::wherein('id', $data)->get();
        }    
        return view('conditions.create', compact('ruleName','masters'));

        /*        $ruleName = $request->query('ruleName');
                $ruleMaster = $request->query('ruleMaster');
                return view('rules.createcondition', compact('ruleName', 'ruleMaster'));*/
//        $first = DynamicMain::find($master)->values()->get()->first();

//        foreach ($masters as $master) {
//            echo $master -> name;
//            $values = $master->values()->get();
//            foreach ($values as $value) {
//                echo $value -> name;
//            }
//        }
//        dd();

//        $masterValues = DynamicMain::find($masterId)->values()->get();
//        foreach ($masters as $master) {
//            echo $master;
//        };
//        dd(DynamicValue::find(1)->master);
//        //$mastervalues = DynamicValue::where('parent_id', $ruleMaster)->get();
//        return view('rules.createcondition', compact('ruleName', 'masters', 'mainmasters'));
    }

    public function store(Request $request) : JsonResponse
    {
        $ruleName = $request->get('ruleName');
        $ruleData = $request->get('ruleData');
        $ruleType = $request->get('ruleType');
        $ruleFrequency = $request->get('ruleFrequency');
        $ruleSchedule = $request->get('ruleSchedule');
        if ($ruleSchedule == 'NA') {
            $ruleSchedule = null;
        } 
        $rule = Rule::create([
            'name' => $ruleName,
            'ruletype' => $ruleType,
            'rulefrequency' => $ruleFrequency,
            'ruleschedule' => $ruleSchedule
        ]);
        $ruleId = $rule->id;
        $ruleConditions = json_decode( $ruleData, true );
        foreach($ruleConditions as $rule) {
            $masterDataItem = null;
            $masters = $rule['master'];
            foreach ($masters as $master) {
                $masterDataItem = $master;
            }
            $masterOperationItem = null;
            $masterOperations = $rule['masterOperations'];
            foreach($masterOperations as $masterOperation) {
                $masterOperationItem = $masterOperation;
            }
            $masterValues = $rule['masterValues'];
            foreach ($masterValues as $masterValue) {
                $dataItem = [];
                $dataItem['rule_id'] = $ruleId;
                $dataItem['master_id'] = $masterDataItem;
                $dataItem['mastervalue_id'] = $masterValue;
                $dataItem['condition'] = $masterOperationItem;

                RuleCondition::unguard();
                $ruleCondition = RuleCondition::create($dataItem);
                RuleCondition::reguard();
            }
        }
        return response()->json(['success' => 'Received rule data']);
    }

    public function destroy(Request $request) : JsonResponse {

        $id = $request->get('id');
        RuleCondition::where('rule_id', $id)->delete();
        Rule::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

    public function edit(Request $request) : View {

        //3 Weeks Rule Myy rulw
        $id = $request->query('id');
        $name = $request->query('name');
        $rule = Rule::find($id);
        $ruleConditions = RuleCondition::where('rule_id', $rule->id)->get();
        $ruleConditionMasters = array();
        // print_r($ruleConditions);
        $masterValues = array();
        foreach ($ruleConditions as $ruleCondition) {
            $ruleConditionMasters[] = $ruleCondition->master_id;
            $masterValues[$ruleCondition->master_id]['clause']=$ruleCondition->condition;
            $masterValues[$ruleCondition->master_id][]=$ruleCondition->mastervalue_id;
        }

        $masters = DynamicMain::whereIn('id', collect(array_values($ruleConditionMasters))->unique())->get();
        // print_r($masters); 
        //die;
        if ($rule['ruletype'] == 'inbound') {
            $rule['ruleschedule'] = 'NA';
        }

//        $ruleConditionMasters = array();
//        $masters = array();
//        foreach ($ruleConditions as $ruleCondition) {
//            $ruleConditionMasters[] = $ruleCondition->master_id;
//        }
//        $uniqueRuleConditionMasters = collect(array_values($ruleConditionMasters))->unique();
//        foreach ($uniqueRuleConditionMasters as $key => $value) {
//             $rulesConditionsForMasters = RuleCondition::where('rule_id', $rule->id)->where('master_id', $value)->get()->toArray();
//             $mastersValues = array();
//             foreach ($rulesConditionsForMasters as $rulesConditionsForMaster) {
//                 $mastersValues[] = $rulesConditionsForMaster;
//             }
//            $masters[$value] = $mastersValues;
//        }
//        Log::info($masters);
//        $mastersJSON = json_encode($masters);
//        return view('rules.edit', compact('rule','masters','masterValues'));
        $rule['name'] = $name;
        return view('conditions.edit', compact('rule','masters','masterValues'));
    }

    public function update(Request $request) : JsonResponse
    {
        $ruleId = $request->get('ruleId');
        $ruleName = $request->get('ruleName');
        $ruleData = $request->get('ruleData');

        $ruleType = $request->get('ruleType');
        $ruleFrequency = $request->get('ruleFrequency');
        $ruleSchedule = $request->get('ruleSchedule');

        if ($ruleSchedule == 'NA') {
            $ruleSchedule = null;
        }

        $rule = Rule::find($ruleId);
        $rule->name = $ruleName;
        $rule->ruletype = $ruleType;
        $rule->ruleFrequency = $ruleFrequency;
        $rule->ruleSchedule = $ruleSchedule;
        $saveStatus = $rule->save();
        if(!$saveStatus) {
            return response()->json(['success' => 'Received rule data']);
        }
        $ruleId = $rule->id;
        $ruleConditions = json_decode( $ruleData, true );
        
        RuleCondition::where('rule_id', $rule->id)->delete();
        foreach($ruleConditions as $rule) {
            $masterDataItem = null;
            $masters = $rule['master'];
            foreach ($masters as $master) {
                $masterDataItem = $master;
            }
            $masterOperationItem = null;
            $masterOperations = $rule['masterOperations'];
            foreach($masterOperations as $masterOperation) {
                $masterOperationItem = $masterOperation;
            }
            $masterValues = $rule['masterValues'];
            foreach ($masterValues as $masterValue) {
                $dataItem = [];
                $dataItem['rule_id'] = $ruleId;
                $dataItem['master_id'] = $masterDataItem;
                $dataItem['mastervalue_id'] = $masterValue;
                $dataItem['condition'] = $masterOperationItem;

                RuleCondition::unguard();
                RuleCondition::updateOrCreate($dataItem);
                RuleCondition::reguard();
            }
        }
        return response()->json(['success' => 'Received rule data']);
    }
}
