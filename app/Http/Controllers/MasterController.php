<?php

namespace App\Http\Controllers;

use App\Models\DynamicMain;
use App\Models\DynamicValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller
{
    public function index(){
        
        $masters=DynamicMain::all();
        $edit=false;
        return view('master.index',compact('masters','edit'));
    }

    public function store(Request $request){

        $unique = DynamicMain::where('name',$request->name)->first();
        if($unique){
            return redirect()->back()->with('error','Master Already Exist');
        }
        $main=0;
        if($request->main){
        $main=1;
        }
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
        // die("I am here to edit");
        $master=DynamicMain::where('id',$id)->first();
        return view('master.index',['masters'=> false,'master'=>$master,'edit'=>true]);
    }

    public function update(Request $request, $id){
        
        $master = DynamicMain::where('name',$request->name)->first();

        // print_r($master);die;
        if($master && $master->master) {
            return redirect()->back()->with('error','You can not edit a "Main Master"');
        }
        if($master){
            return redirect()->back()->with('error','Master Alredy Exist');
        }

        $masterUpdated= DynamicMain::find($id)->update(['name'=>$request->name]);
        if($masterUpdated){
            return redirect()->route('master')->with('status','Master Updated Successfully');
        }
    }

//    public function delete($id){
//        $master=DynamicMain::where('id',$id)->first();
//        return view('master.index',['master'=>$master,'masters'=> false]);
//    }

    public function destroy(Request $request) : JsonResponse {
        
        $id = $request->get('id');
        DynamicValue::where('parent_id', $id)->delete();
        DynamicMain::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }
    
    public function delete($id){
        $master=DynamicMain::where('id',$id)->first();
        return view('master.index',['master'=>$master,'masters'=> false]);
    }

}
