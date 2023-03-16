<?php

namespace App\Http\Controllers;

use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        return view('leads.index', ['leads' => Lead::all()]);
    }

    public function call()
    {
        return view('leads.leadcalls');
    }

    public function assignment()
    {
        return view('leads.leadassignment');
    }

    public function upload()
    {
        return view('leads.leadupload');
    }


}
