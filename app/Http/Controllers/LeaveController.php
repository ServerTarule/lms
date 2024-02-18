<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Holiday;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Leaves;
use Illuminate\Support\Facades\Log;


class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $leaves = Leaves::all();
        $distinctEmployeeIds = Employee::select('id')->distinct()->get();
        $uniqueEmployees = array();

        foreach ($distinctEmployeeIds as $distinctEmployeeId) {
            $uniqueEmployees[] = $distinctEmployeeId->id;
         }

        $employees = Employee::whereIn('id', array_values($uniqueEmployees))->get();

        $events = null;

        return view('leaves.index',compact( 'leaves', 'employees', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        //
//        $createLeave=Leaves::create([
//            'start_time'=>$request->from,
//            'end_time'=>$request->to,
//            'type'=>$request->type,
//            'comment'=>$request->comment,
//            'employee_id'=>$request->employeeid
//
//        ]);
//        if($createLeave){
//            return redirect('/leaves')->with('status','Leave added successfully');
//
//        }
//        return redirect('/leaves')->with('error','Please try again later');
//
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeleaves(Request $request): JsonResponse 
    {

        $employeeId = $request->employeeid;
        $employeeDetails = Employee::find($employeeId);
        if(!empty($employeeDetails)) {
            $createLeave=Leaves::create([
                'start_time'=>$request->from,
                'end_time'=>$request->to,
                'type'=>$request->type,
                'comment'=>$request->comment,
                'employee_id'=>$request->employeeid

            ]);
            if($createLeave){
                return response()->json(['status'=>true,'message' => 'Leave added successfully!']);
            }
        }  
        return response()->json(['status'=>false,'message' => `Error occurred, while adding leave!`]);
    }

    public function getLeaveData($leaveId)
    {
        // $employeeId =  $request->get('employeeId');
        $leave = Leaves::where('id',$leaveId)->first();
        $employee=[];
        if(isset($leave) && isset($leave->employee_id)) {
            $employeeId = $leave->employee_id;
            $employee = Employee::where('id',$employeeId)->first();
        }
        
        return response()->json(['employee'=>$employee,'leave'=>$leave]);
    }

    public function leavelist($id){
        $leaves = Leaves::where('employee_id', $id)->get();
        return view('leaves.view',compact( 'leaves'));
    }

    public function leavecalendar($id){

        $events = [];

        $leaves = Leaves::where('employee_id', $id)->get();

        foreach ($leaves as $leave) {
            $events[] = [
                'title' => $leave->comment,
                'start' => $leave->start_time,
                'end' => $leave->end_time,
            ];
        }

        $holidays = Holiday::all();

        foreach ($holidays as $holiday) {
            $events[] = [
                'title' => $holiday->name,
                'start' => $holiday->day,
                'allDay' => true
            ];
        }

        return view('leaves.calendar', compact('events', 'holidays'));
    }

    public function updateleave(Request $request,$id): JsonResponse {
        $leave = Leaves::find($id);
        if(empty($leave)) {
            return response()->json(['status'=>false, 'message'=>'Leave with given id does not exists.!']);
        }
        else {
           //echo "Employee Id".
           $employeeId = $request->employeeid;
            $emp = Employee::find($employeeId);
            if(empty($emp)) {
                return response()->json(['status'=>false, 'message'=>'Employee with given id/name does not exists.!']);
            }
            else{
                $leaveUpdateStatus=Leaves::find($id)->update([
                    'start_time'=>$request->from,
                    'end_time'=>$request->to,
                    'type'=>$request->type,
                    'comment'=>$request->comment,
                    'employee_id'=>$request->employeeid
                    
                ]);
                if($leaveUpdateStatus){
                    return response()->json(['status'=>true, 'message'=>'Leave updated successfully']);
                }
            }
        }
        return response()->json(['status'=>false, 'message'=>'Some Error Occured']);
    }
    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Leaves::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
