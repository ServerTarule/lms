<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index($id){
        $master_id=$id;
        $employee = Employee::where('master_id',null)->get();
        $mains = Employee::where('master_id',$id)->get();
        return view('master.master',compact('employee','master_id','mains'));
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
