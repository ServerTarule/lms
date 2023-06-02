<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\Doctors;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use App\Models\DynamicValue;
use Illuminate\Support\Facades\DB;
class CenterController extends Controller
{
    //
    public function index()
    {
        $centers = DB::table('centers as c')
        ->select('c.*', 'dym.name as state_name', 'dymc.name as city_name')
        ->leftJoin('dynamic_values as dym', function($join){
            $join->on('c.state', '=', 'dym.id')
                 ->where('dym.parent_id', "7");
        })
        ->leftJoin('dynamic_values as dymc', function($join){
            $join->on('c.city', '=', 'dymc.id')
                 ->where('dymc.parent_id', "8");
        })->get();
        $doctor=Doctors::all();
        $state=DB::table('dynamic_values as dm')->select('dm.*')->where('dm.parent_id','7')->join('dynamic_mains as dym', 'dm.parent_id', '=', 'dym.id')->get();
        return view('center.index',compact( 'centers','doctor','state'));
    }

    public function addCenter(Request $request){
        // print_r($request->role_id);die;
        $center=Center::create([
            'centerDetails'=>$request->centerDetails,
            'mobile'=>$request->mobile,
            'alternateMobile'=>$request->alternateMobile,
            'state'=>$request->state,
            'city'=>$request->city,
            'ownerName'=>$request->ownerName,
            'EmailId'=>$request->EmailId,
        ]);

        // print_r($center->toArray()); die;
        if(isset($request->role_id) && isset($center)) {
            $centerId = $center->id;
            $ids = $request->role_id;//[34, 56, 100, 104];
            $doctor= Doctors::whereIn("id", $ids)->update([
                'center_id' => $centerId
            ]);
        }
        if($center){
            return redirect('centers')->with('status', 'Doctor Created Successfully');

        }
        return redirect('centers')->with('status', 'Some Error Occured');
    }

    public function edit(Request $request): JsonResponse {
        $centerId =  $request->get('centerId');
        $center=Center::where('id',$centerId)->first();
        return response()->json(['center' => $center]);
    }


    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Center::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }


}

