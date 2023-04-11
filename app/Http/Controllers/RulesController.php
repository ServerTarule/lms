<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class RulesController extends Controller
{
    public function index() : View {
        //Should fetch list of Rules created
        $rules = Rule::all();
        return view('rules.index',compact('rules'));
    }

    public function create() : View {
        $masters=DynamicMain::where('master', '1')->get();
        return view('rules.create',compact('masters'));
    }

    public function store(Request $request) : RedirectResponse {
/*        $ruleName = $request->input('ruleName');
        $ruleMaster = $request->input('ruleMaster');
        return redirect()->route('rules.create.condition', compact('ruleName', 'ruleMaster'));*/
//        dd($request->all());
        $ruleMasterCount = $request->input('ruleMasterRowCount');
//        dd($ruleMasterCount);
        $data = array();
        for ($i = 1; $i <= $ruleMasterCount; $i++) {
//            $property = 'ruleName_'.$i;
            $data[] = $request->input('ruleMaster_'.$i);
        }

//        $ruleName = $request->input('ruleName');



//        $data = [
//            'ruleName' => $request->input('ruleName'),
//            'ruleMaster' => $request->input('ruleMaster'),
//            'ruleMaster1' => $request->input('ruleMaster_1'),
//            'ruleMaster2' => $request->input('ruleMaster_2')
//        ];

        $ruleName = $request->input('ruleName');
//        $ruleMaster = $request->input('ruleMaster');
        return redirect()->route('conditions.create', compact('ruleName', 'data'));
    }

}
