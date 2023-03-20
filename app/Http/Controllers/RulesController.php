<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RulesController extends Controller
{
    public function index() : View {
        //Should fetch list of Rules created
        $rules = null;
        return view('rules.index',compact('rules'));
    }

    public function create() : View {
        $masters=DynamicMain::all();
        return view('rules.create',compact('masters'));
    }

    public function store(Request $request) : RedirectResponse {
/*        $ruleName = $request->input('ruleName');
        $ruleMaster = $request->input('ruleMaster');
        return redirect()->route('rules.create.condition', compact('ruleName', 'ruleMaster'));*/

        $data = [
            'ruleName' => $request->input('ruleName'),
            'ruleMaster' => $request->input('ruleMaster')
        ];

        $ruleName = $request->input('ruleName');
        $ruleMaster = $request->input('ruleMaster');
        return redirect()->route('conditions.create', compact('data'));
    }

}
