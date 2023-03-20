<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use Illuminate\Http\Request;

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
        $value = DynamicValue::create([
            'name' => $request->name,
            'parent_id' => $id,
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
}