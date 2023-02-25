<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{


    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {

        $email = $request->email;
        $password = $request->password;
        $log = Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1]);
        if ($log) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
        return redirect()->back()->with('status', 'Credentials doesn\'t match');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
