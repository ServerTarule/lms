<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Leaves;


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
        $employees = Employee::all();
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
    public function store(Request $request)
    {
        $createLeave=Leaves::create([
            'start_time'=>$request->from,
            'end_time'=>$request->to,
            'type'=>$request->type,
            'comment'=>$request->comment,
            'employee_id'=>$request->employeeid

        ]);
        if($createLeave){
            return redirect('/leaves')->with('status','Leave added successfully');

        }
        return redirect('/leaves')->with('error','Please try again later');

    }

    public function view($id){
        $leaves = Leaves::where('employee_id', $id)->get();
        return view('leaves.view',compact( 'leaves'));
    }

    public function calendar($id){

        $events = [];

        $leaves = Leaves::where('employee_id', $id)->get();

        foreach ($leaves as $leave) {
            $events[] = [
                'title' => $leave->comment,
                'start' => $leave->start_time,
                'end' => $leave->end_time,
            ];
        }

        return view('leaves.calendar', compact('events'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
