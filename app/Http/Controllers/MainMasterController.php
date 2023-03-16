<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Employee;
use Illuminate\Http\Request;

class MainMasterController extends Controller
{
    public function index($id){

        $master =DynamicMain::where('id', $id)->first();
        $mainmasters = DynamicValue::where('parent_id', $id)->get();
        //dd($dynamicmasters);
        return view('mainmaster.index', compact('mainmasters', 'master'));


/*        $master =DynamicMain::where('id', $id)->first();
        return view('mainmaster.index',compact('master'));*/
/*        $master_id = $id;
        $employee = Employee::where('master_id',null)->get();
        $mains = Employee::where('master_id',$id)->get();
        return view('mainmaster.index',compact('employee','master_id','mains'));*/
    }
    public function store(Request $request, $id){
        $employee=Employee::where('id',$request->master)->update(['master_id'=>$id]);
        if($employee){
            return redirect()->back()->with('status', 'User Assign Successfully');
        }
        return redirect()->back()->with('error', 'Something Went Wrong');

    }

    public function remove($id){
        $employee=Employee::where('id',$id)->update(['master_id'=>null]);
        if($employee){
            return redirect()->back()->with('status', 'User Remove From Master Successfully');
        }
        return redirect()->back()->with('error', 'Something Went Wrong');
    }
}
