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
//        dd($data);
        $ruleName = $request->query('ruleName');
//        $masterId = $data['ruleMaster'];
//        $masterId1 = $data['ruleMaster1'];
//        $masterId2 = $data['ruleMaster2'];
//        $masters = DynamicMain::wherein('id', [$masterId,$masterId1,$masterId2])->get(); //Need to use where in when multiple ids are available
//        $masters = DynamicMain::wherein('id', [$masterId])->get(); //Need to use where in when multiple ids are available
        $masters = DynamicMain::wherein('id', $data)->get(); //Need to use where in when multiple ids are available
//        $masters=DynamicMain::where('master', '1')->get();
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
//        Log::info($ruleName);
//        Log::info($ruleData);

        $rule = Rule::create(['name' => $ruleName]);
        $ruleId = $rule->id;
//        Log::info($rule->id);

        $ruleConditions = json_decode( $ruleData, true );

        $data = [];
//        $rowConditionData = [];

        foreach($ruleConditions as $rule) {

            $masterDataItem = null;
            $masters = $rule['master'];
            foreach ($masters as $master) {
                $masterDataItem = $master;
//                Log::info($master);
            }

            $masterOperationItem = null;
            $masterOperations = $rule['masterOperations'];
            foreach($masterOperations as $masterOperation) {
                $masterOperationItem = $masterOperation;
//                Log::info($masterOperation);
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
}
