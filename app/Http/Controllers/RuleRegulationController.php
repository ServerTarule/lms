<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use Illuminate\View\View;

class RuleRegulationController extends Controller
{
    public function index() : View {
        $rules = null;
        return view('rulesandregulations.index',compact('rules'));
    }

    public function show() : View {
        $masters=DynamicMain::all();
        return view('rulesandregulations.condition',compact('masters'));
    }
}
