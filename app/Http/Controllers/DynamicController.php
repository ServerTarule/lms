<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use Illuminate\Http\Request;

class DynamicController extends Controller
{
    public function index(){
        $masters=DynamicMain::all();
        return view('master.index',compact('masters'));
    }

    public function store(Request $request){
        $unique = DynamicMain::where('name',$request->name)->first();
        if($unique){
            return redirect()->back()->with('error','Master Alredy Exist');
        }
        $main=0;
        if($request->main){
        // dd($request->main);
        $main=1;
        }
        // dd($main);
        $master=DynamicMain::create([
            'name'=>$request->name,
            'master'=>$main,
        ]);
        if($master){
            return redirect()->back()->with('status','Master Added Successfully');
        }

        return redirect()->back()->with('error','Something Went Wrong');

    }

    public function edit($id){
        $master=DynamicMain::where('id',$id)->first();

        return view('master.index',['master'=>$master,'masters'=> false]);
    }

    public function update(Request $request, $id){
        $unique = DynamicMain::where('name',$request->name)->first();
        if($unique){
            return redirect()->back()->with('error','Master Alredy Exist');
        }

        $master= DynamicMain::find($id)->update(['name'=>$request->name]);
        if($master){
            return redirect()->route('master')->with('status','Master Added Successfully');
        }
    }
}
