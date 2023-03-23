<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateMaster;

class TemplateController extends Controller
{
    //
    public function index()
    {
        $templateMaster = TemplateMaster::all();
        
        return view('template.index',compact( 'templateMaster'));
    }
}
