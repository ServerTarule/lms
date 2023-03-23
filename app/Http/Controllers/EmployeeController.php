<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee=Employee::all();
        $user=User::all();
        $role=Role::all();
        $designation=Designation::all();
        return view('employee.index',compact('employee','user','role','designation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.addemployee');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $usercheck=User::where('email',$request->email)->first();
        if($usercheck){
            return redirect()->back()->with('error','User already exist');
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
        ]);
        if(!$user){
            return redirect()->back()->with('error','Something Went Wrong!');
        }

        $employee=Employee::create([
            'name'=>$request->name,
            'role_id'=>$request->role_id,
            'contact'=>$request->contact,
            'user_id'=>$user->id,
            'dob'=>$request->dob,
            'doj'=>$request->doj,
            'alternate_contact'=>$request->alternate_contact,
            'designation_id'=>$request->designation_id,
            'profile_img'=>$request->profile_img,
        ]);
        if($employee){
            return redirect('/employee')->with('status','Employee added successfully');

        }
        return redirect('/employee')->with('error','Please try again later');

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
        $employee=Employee::find($id);
        // dd($employee);
        $user=User::all();
        $role=Role::all();
        $designation=Designation::all();
        return view('employee.editemployee',compact('employee','user','role','designation'));
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
