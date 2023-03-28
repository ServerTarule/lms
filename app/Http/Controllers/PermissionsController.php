<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\Employee;
use App\Models\EmployeeRule;
use App\Models\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionsController extends Controller
{
    public function index() {
        $employees = Employee::all();
        return view('permissions.index', compact('employees'));
    }

    public function edit(Request $request) {
        $employeeId = $request->id;
        $masters = DynamicMain::all();
        $rules = Rule::all();
//        $employeeRules = EmployeeRule::where('employee_id', $employeeId)->get();
//        $employeeRule = EmployeeRule::where(['employee_id' => '1', 'rule_id' => '2'])->first()->status;
//        Log::info($employeeRule);
        return view('permissions.edit', compact('employeeId', 'masters', 'rules'));
    }

    public function update(Request $request) : JsonResponse {
        $employeeId = $request->get('employeeId');
        $rulesData = $request->get('rulesDate');
//        Log::info($employeeId);
//        Log::info($rulesData);

        $rules = json_decode( $rulesData, true );

        foreach($rules as $rule) {

//            $dataItem = [];
//            $dataItem['employee_id'] = $employeeId;
//            $dataItem['rule_id'] = $rule['rule'];
//            $dataItem['status'] = $rule['ruleStatus'];

            EmployeeRule::unguard();
            EmployeeRule::updateOrCreate(
                ['employee_id' => $employeeId, 'rule_id' => $rule['rule']],
                ['status' => $rule['ruleStatus']]);
            EmployeeRule::reguard();

        }

        return response()->json(['success' => 'Received rule data']);
    }

    public function masterIndex() : JsonResponse {
        $masters = DynamicMain::all();
        return response()->json([
            'masters' => $masters
        ]);
    }
}
