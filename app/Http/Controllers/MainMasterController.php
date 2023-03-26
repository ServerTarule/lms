<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Employee;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MainMasterController extends Controller
{
    public function index($id){

        $master =DynamicMain::where('id', $id)->first();
        $leadStatuses = null;
        $states = null;
        //Log::info($master->name);
        if($master->name == 'Lead Stages') {
            $leadStatusMaster = DynamicMain::where('name', 'Lead Status')->first();
            //Log::info($leadStatusMaster);
            $leadStatuses = DynamicValue::where('parent_id', $leadStatusMaster->id)->get();
            //Log::info($leadStatuses);
        }

        if($master->name == 'Cities') {
            $stateMaster = DynamicMain::where('name', 'States')->first();
            $states = DynamicValue::where('parent_id', $stateMaster->id)->get();
        }
        $mainmasters = DynamicValue::where('parent_id', $id)->get();
//        Log::info($states);
//        Log::info(count($states));
        return view('mainmaster.index', compact('mainmasters', 'master', 'leadStatuses', 'states'));


/*        $master =DynamicMain::where('id', $id)->first();
        return view('mainmaster.index',compact('master'));*/
/*        $master_id = $id;
        $employee = Employee::where('master_id',null)->get();
        $mains = Employee::where('master_id',$id)->get();
        return view('mainmaster.index',compact('employee','master_id','mains'));*/
    }
    public function store(Request $request, $id) : RedirectResponse{
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
