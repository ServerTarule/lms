<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employee=Employee::all();

        $employees= DB::table('employees as e')
        ->select('e.*', 'd.name as designation_type', 'u.name as user_name','r.name as role_name')
        ->leftJoin('designations as d', function($join){
            $join->on('e.designation_id', '=', 'd.id');
        })
        ->leftJoin('users as u', function($join){
            $join->on('e.user_id', '=', 'u.id');
        })
        ->leftJoin('roles as r', function($join){
            $join->on('e.role_id', '=', 'r.id');
        })->get();
        
        $employee=Employee::all();

        // foreach($employee as $employe) {
        //     echo "---------------+++++++++++++++++++--------------";
        //     print_r($employe->role);
            
        //     echo "---------------*******************--------------";
        // }
        // die;

        $user=User::all();
        $role=Role::all();
        $designation=Designation::all();
        // print_r($employee);
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
    public function store(Request $request): JsonResponse {

        // echo "Role Id = ".$request->role_id;
        $allowedExtension = ['png','jpg','jpeg','gif'];
        $profilImg="";
        if($request->file) {
            $fileExtension = $request->file('file')->extension();
            if(!in_array($fileExtension,$allowedExtension)) {
                return response()->json(['status'=>false, 'message'=>'This extension of file not accepted!']);
            }
            $name = time().'_'.$request->file->getClientOriginalName();
            $profilImg = "uploads/".$name;
            $filePath = $request->file->move(public_path('uploads'), $name);
        }
        $usercheck=User::where('email',$request->email)->first();
        if($usercheck){
            return response()->json(['status'=>false, 'message'=>'User already exist!']);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
        ]);
        if(!$user){
            return response()->json(['status'=>false, 'message'=>'Something Went Wrong!']);
        }
        $postArray = [
            'name'=>$request->name,
            'role_id'=>$request->role_id,
            'contact'=>$request->contact,
            'user_id'=>$user->id,
            'dob'=>$request->dob,
            'doj'=>$request->doj,
            'alternate_contact'=>$request->alternate_contact,
            'designation_id'=>$request->designation_id,
            'profile_img'=>$profilImg,
        ];
        $employee=Employee::create($postArray);
        if($employee){
            return response()->json(['status'=>true, 'message'=>'Employee added successfully!']);
        }
        return response()->json(['status'=>false, 'message'=>`Employee couldn't be added!`]);
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
    public function edit(Request $request): JsonResponse {
        $employeeId =  $request->get('employeeId');
        $employee = Employee::where('id',$employeeId)->first();
        $user=[];
        if(isset($employee) && isset($employee->user_id)) {
            $userId = $employee->user_id;
            $user = User::where('id',$userId)->first();
        }
        
        return response()->json(['employee'=>$employee,'user'=>$user]);
    }

    public function updateEmployee(Request $request,$employeeId): JsonResponse {
        $request->password;
        $userId = $request->userId;
      
        $request->name;
        $dataToUpdate = [
            'name'=>$request->name,
            'email'=>$request->email,
        ];
        if($request->password) {
            $dataToUpdate['password'] =  Hash::make($request->password);
        }
        $allowedExtension = ['png','jpg','jpeg','gif'];
        $profilImg="";
        if($request->file) {
            $fileExtension = $request->file('file')->extension();
            if(!in_array($fileExtension,$allowedExtension)) {
                return response()->json(['status'=>false, 'message'=>'This extension of file not accepted!']);
            }
            $name = time().'_'.$request->file->getClientOriginalName();
            $profilImg = "uploads/".$name;
            $filePath = $request->file->move(public_path('uploads'), $name);
        }
        $user=User::find($userId)->update(
            $dataToUpdate
        );
        if(!$user){
            return response()->json(['status'=>false, 'message'=>'Something Went Wrong!']);
        }

        $emp = Employee::find($employeeId);
        $employee=Employee::find($employeeId)->update([
            'name'=>$request->name,
            'role_id'=>$request->role_id,
            'contact'=>$request->contact,
            'user_id'=>$userId,
            'dob'=>$request->dob,
            'doj'=>$request->doj,
            'alternate_contact'=>$request->alternate_contact,
            'designation_id'=>$request->designation_id,
            'profile_img'=>$profilImg,
            
        ]);
        if($employee){
            return response()->json(['status'=>true, 'message'=>'Employee updated successfully']);
        }
        return response()->json(['status'=>false, 'message'=>'Some Error Occured']);
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
