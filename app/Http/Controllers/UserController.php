<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function index()
    {
        $users = User::all()->where('role_id', '!=',null);

        return view('users.index',compact( 'users'));
    }

    public function profile()
    {
        $currentUser = auth()->user();
        // print_r($currentUser);
        $userId = $currentUser->id;
        //where($userId)->first()->where('role_id', '!=',null)->
        $userProfileDetail = User::where('id', '=',$userId)->where('role_id', '!=',null)->first();
        // echo "<pre>";print_r($userProfileDetail->toArray());
        return view('users.profile',compact( 'userProfileDetail'));
    }

    public function updateprofile(Request $request): JsonResponse {
        $userId = $request->userid;
        $currentUser = auth()->user();
        // print_r($currentUser);
        $currentUserId = $currentUser->id;
        if($userId != $currentUserId) {
            return response()->json(['status'=>false, 'message'=>`You are not allowed to update other user profile!`]);
        }
        // echo "==userId==".$userId;
        $user = User::find($userId);
        if(empty($user)) {
            return response()->json(['status'=>false, 'message'=>'User with given id does not exists!']);
        }
        // print_r($user);
        $dataToUpdate = [
            'name'=>$request->name,
        ];
        $allowedExtension = ['png','jpg','jpeg','gif'];
        $profilImg="";
        // echo "<pre>";print_r($request->file);
        if($request->file) {
            $fileExtension = $request->file('file')->extension();
            // echo "fileExtension ==".$fileExtension;
            if(!in_array($fileExtension,$allowedExtension)) {
                return response()->json(['status'=>false, 'message'=>'This extension of file not accepted!']);
            }
            $name = time().'_'.$request->file->getClientOriginalName();
            $profilImg = "uploads/".$name;
            $filePath = $request->file->move(public_path('uploads'), $name);
            $dataToUpdate["profile_img"] = $profilImg;
        }
        // print_r($dataToUpdate);
        // die;
        $userStatus=User::find($userId)->update(
            $dataToUpdate
        );
        // print_r($userStatus);
        if($userStatus){
            return response()->json(['status'=>false, 'message'=>'Profile updated successfully!']);
        }
        return response()->json(['status'=>false, 'message'=>'Some Error Occured']);
    }

    public function userpassword()
    {
        $currentUser = auth()->user();
        // print_r($currentUser);
        $userId = $currentUser->id;
        //where($userId)->first()->where('role_id', '!=',null)->
        $userProfileDetail = User::where('id', '=',$userId)->where('role_id', '!=',null)->first();
        // echo "<pre>";print_r($userProfileDetail->toArray());
        return view('users.change-password',compact( 'userProfileDetail'));
    }

    public function updatepassword(Request $request): JsonResponse {
        $userId = $request->userid;
        $currentUser = auth()->user();
        $currentUserId = $currentUser->id;
        if($userId != $currentUserId) {
            return response()->json(['status'=>false, 'message'=>`You are not allowed to update other user profile!`]);
        }
        $user = User::find($userId);
        $hasher = app('hash');
        if (!isset($user)) {
            return response()->json(['error'=>true, 'message'=>'User with given id does not exists!']);
        }
        else if (isset($user) && !$hasher->check($request->currentpassword, $user->password)) {
            // Success
            return response()->json(['error'=>true, 'message'=>'Current password does not match with given current password!']);
        }
        else {
            $dataToUpdate = [
                'password'=> Hash::make($request->newpassword),
            ];
            $userStatus=User::find($userId)->update(
                $dataToUpdate
            );
            if($userStatus){
                return response()->json(['error'=>false, 'message'=>'Password updated successfully!']);
            }
            return response()->json(['error'=>true, 'message'=>'Some Error Occured']);
        }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
    }
}