<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CommunicationController extends Controller
{
    public function index()
    {
        return view('communications.index');
    }
}
