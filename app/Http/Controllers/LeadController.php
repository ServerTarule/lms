<?php

namespace App\Http\Controllers;

class LeadController extends Controller
{
    public function status()
    {
        return view('lead.leadstatus');
    }

    public function call()
    {
        return view('lead.leadcalls');
    }

    public function assignment()
    {
        return view('lead.leadassignment');
    }

    public function upload()
    {
        return view('lead.leadupload');
    }


}
