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
        $masters = DynamicMain::wherein('id', $data)->get();
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

        Log::info($request);

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
}
