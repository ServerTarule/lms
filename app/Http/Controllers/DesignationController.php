<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designations = Designation::all();
        return view('designation.index',compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unique = Designation::where('name',$request->name)->first();
        if($unique){
        return redirect()->back()->with('error','Designation Already Exist');

        }
        $designation = Designation::create([
            'name'=> $request->name,
        ]);

        if($designation){

        return redirect()->back()->with('status','Designation Added Successfully');
        }

        return redirect()->back()->with('error','Something went wrong');
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
        $designation=Designation::where('id',$id)->first();
        return view('designation.index',['designation'=> $designation,'designations'=> false]);
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

        $unique = Designation::where('name',$request->name)->first();
        if($unique){
        return redirect()->back()->with('error','Designation Already Exist');
        }

        $designation = Designation::find($id)->update(['name'=>$request->name]);
        if($designation){
        return redirect()->route('designation')->with('status','Designation Updated Successfully');

        }
        return redirect()->back()->with('error','Something went wrong');

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
