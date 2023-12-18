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
        ->select('e.*', 'd.name as designation_type', 'u.name as user_name','u.status as user_status','r.name as role_name')
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
// print_r($employees->toArray());
        // foreach($employee as $employe) {
        //     echo "---------------+++++++++++++++++++--------------";
        //     print_r($employe->user->toArray());
            
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

    public function validateEmployeeData(Request $request) {
        // 'contact'=>$request->contact,
        // 'user_id'=>$user->id,
        // 'dob'=>$request->dob,
        // 'doj'=>$request->doj,
        // 'alternate_contact'=>$request->alternate_contact,
        // 'designation_id'=>$request->designation_id,
        // 'profile_img'=>$profilImg,
        $response = ['status'=>false, 'message'=>"Failed to add user"];
        if(!$request->name || !isset($request->name) || $request->name ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as name is blank.";
        }
        else if(!$request->email || !isset($request->email) || $request->email ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as email is blank.";
        }
        else if(!$request->role_id || !isset($request->role_id) || $request->role_id ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as User Type (Role) is not given.";
        }
        else if(!$request->password || !isset($request->password) || $request->password ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as password is not provided.";
        }
        else if(!$request->contact || !isset($request->contact) || $request->contact ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as mobile no is not provided.";
        }
        else if(!$request->dob || !isset($request->dob) || $request->dob ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as dob is not provided.";
        }
        else if(!$request->doj || !isset($request->doj) || $request->contact ==="") {
            $response['message'] =  $response['message']." due to wrong data in request as doj is not provided.";
        }

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse {
        $this->validateEmployeeData($request);
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
            'role_id'=>$request->role_id,
            'password'=> Hash::make($request->password),
            "profile_img" => $profilImg
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
        $emp = Employee::find($employeeId);
        if(empty($emp)) {
            return response()->json(['status'=>false, 'message'=>'Employee with given id does not exists.!']);
        }
        $request->password;
        $userId = $request->userId;
        $usercheck = $this->checkIfUserEmailIsUnique($request->email, true, $userId);
        if(isset( $usercheck) && !empty( $usercheck)) {
            return response()->json(['status'=>false, 'message'=>'There is existing employee with given email, please chage the email id.!']);
        }
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
            $dataToUpdate["profile_img"] = $profilImg;
        }
        // print_r($dataToUpdate); die;
        $user=User::find($userId)->update(
            $dataToUpdate
        );

        // print_r($user);
        if(!$user){
            return response()->json(['status'=>false, 'message'=>'Something Went Wrong!']);
        }

        
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

    public function toggleemployeestatus(Request $request,$employeeId): JsonResponse {
        $emp = Employee::find($employeeId);
        // print_r($emp );
        if(!isset($mp) && empty($emp)) {
            return response()->json(['status'=>false, 'message'=>'Employee with given id does not exists.!']);
        }
        else {
            $userId = $emp->user_id;
            $user = User::find($userId);
            if(!isset($user) && empty($user)) {
                return response()->json(['status'=>false, 'message'=>'There is not user asscociated for the epmloyee with given id.!']);
            }
            else {
                $statusStr = "activated";
                $status = 1;
                if($request->status == false || $request->status == "false") {
                    $statusStr = "de-activated";
                    $status= 0;
                }
                $userUpdateStatus =DB::table('users')->where('id', $userId)->update(['status' => $status]);
                if($userUpdateStatus){
                    return response()->json(['status'=>true, 'message'=>"Employee $statusStr successfully"]);
                }
            }
        }
        return response()->json(['status'=>false, 'message'=>'Some Error Occured']);
    }

    public function checkIfUserEmailIsUnique($email, $isEdit = false, $id =0 ) {
        if($isEdit == true) {
            $user = User::where('id','!=',$id)->where('email',$email)->first();
        }
        else {
            $user = User::where('email',$email)->first();
        }
        return $user;
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
