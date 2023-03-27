<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\viewleaveModel;


class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $leaveData = viewleaveModel::all();
        
        return view('leave.index',compact( 'leaveData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $createLeave=viewleaveModel::create([
            'employeeName'=>$request->leaveEmpyoeeName,
            'fromDate'=>$request->fromDate,
            'endDate'=>$request->endDate,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime,
            'upComingLeaves'=>"1",
            'leaveType'=>$request->leaveType,
            'leaveDescription'=>$request->leaveDescription,
            
        ]);
        if($createLeave){
            return redirect('/leave')->with('status','Leave added successfully');

        }
        return redirect('/leave')->with('error','Please try again later');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        
    

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
