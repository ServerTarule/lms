<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DynamicMasterController extends Controller
{
    public function index($id)
    {
        $master =DynamicMain::where('id', $id)->first();
        $dynamicmasters = DynamicValue::where('parent_id', $id)->get();
        //dd($dynamicmasters);
        return view('dynamicmaster.index', compact('dynamicmasters', 'master'));
    }

    public function store(Request $request, $id)
    {
        $unique = DynamicValue::where(['parent_id' => $id, 'name' => $request->name])->first();
        if ($unique) {
            return redirect()->back()->with('error', 'Value Already Exists');
        }
        $dependentId = null;

        //Log::info($request->leadStatusMasterId);
        //Log::info($request->leadStatusId);

        if ($request->leadStatusMasterId != null) {
            $dependentId = $request->leadStatusMasterId;
        }

        if ($request->stateMasterId != null) {
            $dependentId = $request->stateMasterId;
        }

        $value = DynamicValue::create([
            'name' => $request->name,
            'parent_id' => $id,
            'dependent_id' => $dependentId
        ]);
        if ($value) {
            return redirect()->back()->with('status', 'Value Added Successfully');
        }
    }
    public function edit($id)
    {
        $master = DynamicValue::where('id', $id)->first();
        // dd($master->main);
        return view('master.value', ['master' => $master, 'masters' => false]);
    }

    public function update(Request $request, $id)
    {
        $unique = DynamicValue::where(['name'=>$request->name,'parent_id'=>$request->parent_id])->first();
        if ($unique) {
            return redirect()->back()->with('error', 'Master Already Exist');
        }

        $master = DynamicValue::find($id)->update(['name' => $request->name]);
        if ($master) {
            return redirect()->back()->with('status', 'Master Added Successfully');
        }
        return redirect()->back()->with('error','Something Went Wrong');
    }

    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        DynamicValue::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
}
