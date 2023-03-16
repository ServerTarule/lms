<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        $states=State::all();
        return view('states.index',compact('states'));
    }
}
