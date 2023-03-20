<?php

namespace App\Http\Controllers;

use App\Models\ActionType;

class ActionTypeController extends Controller
{
    public function index(){
        $actions = ActionType::all();
        return view('actions.index',compact('actions'));
    }
}
