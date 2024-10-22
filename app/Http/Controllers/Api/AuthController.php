<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Employee;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Credentials Do Not Match', 401);
        }

        $user = User::where('email', $request->email)->where('role_id', 16)->first();

        //echo $user;
        // echo $user  == null;
        if ($user == null) {
            return [

                "status" => false,
                "message" => "User not Found"
            ];
        } else {
            $emplyeeData = Employee::where('user_id', $user->id)->first();

            // echo $user->createToken('Api Token '.$user->name)->plainTextToken;
            return $this->success([
                'user' => $emplyeeData,
                // 'token'=> $user->createToken('Api Token '.$user->name)->plainTextToken
            ]);
        }

    }
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->aLL());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 1,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token' . $user->name)->plainTextToken
        ]);
    }

    public function logout()
    {

        return 'test';
    }
}
