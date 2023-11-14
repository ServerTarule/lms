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
        $master=DynamicMain::where('id',$id)->first();
        return view('master.index',['masters'=> false,'master'=>$master,'edit'=>true]);
    }

    public function update(Request $request, $id){
        
        $master = DynamicMain::where('name',$request->name)->first();
        $existing = DynamicMain::where('name', '=', $request->name)->where('id', '!=',$id)->first();   
        if($master && $master->master) {
            return redirect()->back()->with('error','You can not edit a "Main Master"');
        }
        if($existing){
            return redirect()->back()->with('error','Master with this name already exists, please hange the name.');
        }

        $masterUpdated= DynamicMain::find($id)->update(['name'=>$request->name]);
        if($masterUpdated){
            // return redirect()->back()->with('status','Master updated successfully');//
            return redirect()->route('master-list')->with('status','Master updated successfully.');
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
        return response()->json(['message' => 'Master deleted successfully']);
    }
    
    public function delete($id){
        $master=DynamicMain::where('id',$id)->first();
        return view('master.index',['master'=>$master,'masters'=> false]);
    }

}
