<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OccasionController extends Controller
{
    public function index(){
        return view('occasions.index');
    }
}
