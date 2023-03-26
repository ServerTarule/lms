<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\Employee;
use App\Models\Rule;
use Illuminate\Http\JsonResponse;
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
        return view('permissions.edit', compact('employeeId', 'masters', 'rules'));
    }

    public function update(Request $request) {

//        dd($request->input('employeePermissionRules'));
//        dd($request->all());

//        dd($request->get('rule_1'));
        dd($request->input('rule_1'));

        $employees = Employee::all();
        return view('permissions.index', compact('employees'));
    }

    public function masterIndex() : JsonResponse {
        $masters = DynamicMain::all();
        return response()->json([
            'masters' => $masters
        ]);
    }
}
