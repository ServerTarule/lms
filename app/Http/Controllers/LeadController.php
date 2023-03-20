<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\State;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $states = State::all();
        return view('leads.create', compact('states'));
    }

    public function store(Request $request) {
        dd($request);
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
