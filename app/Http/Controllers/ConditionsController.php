<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
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
        $ruleName = $data['ruleName'];
        $masterId = $data['ruleMaster'];
        $masters = DynamicMain::wherein('id', [1,2,3])->get(); //Need to use where in when multiple ids are available
//        $masters = DynamicMain::wherein('id', [$masterId])->get(); //Need to use where in when multiple ids are available
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
        print_r($request->all());
        $ruleConditions = $request->get('ruleData');
        return response()->json($ruleConditions);
    }
}
