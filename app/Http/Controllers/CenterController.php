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

    public function addCenter(Request $request): JsonResponse {
        $validation = $this->validateInput($request);
        if($validation["error"] == true || $validation["error"] == 1) {
            return response()->json($validation);
        }
        $center=Center::create([
            'centerDetails'=>$request->get("centerDetails"),
            'mobile'=>$request->get("mobile"),
            'alternateMobile'=>$request->get("alternateMobile"),
            'state'=>$request->get("state"),
            'city'=>$request->get("city"),
            'ownerName'=>$request->get("ownerName"),
            'EmailId'=>$request->get("EmailId"),
        ]);
        $doctorId = $request->get("roleId");
        if(isset($doctorId) && $center) {
            $centerId = $center->id;
            $ids = $request->get("roleId");
            $doctor= Doctors::whereIn("id", $ids)->update([
                'center_id' => $centerId
            ]);
        }
        if($center){
            return response()->json(['status'=>true, 'message'=>'Center added successfully.']);
        }
        return response()->json(['status'=>true, 'message'=>'Some Error Occured']);
    }

    public function edit(Request $request): JsonResponse {
        $centerId =  $request->get('centerId');
        $center=Center::where('id',$centerId)->first();
        $doctors=  DB::table('doctors as d')->select('d.id')->where('center_id',$centerId)->get()->toArray();
        $doctorIds = array_column($doctors, 'id');
        return response()->json(['center' => $center,'doctors'=>$doctorIds]);
    }

    private function validateInput(Request $request) {
        $isError = false;
        $centerDetails = $request->get("centerDetails");
        $mobile = $request->get("mobile");
        $alternateMobile = $request->get("alternateMobile");
        $state = $request->get("state");
        $city = $request->get("city");
        $ownerName = $request->get("ownerName");
        $EmailId = $request->get("EmailId");
        $doctorId = $request->get("roleId");
        $validationMessage = "";
        if($centerDetails==null || $centerDetails=="") {
            $validationMessage .= "Center details is mandatory field. </br>";
        }
        if($mobile==null || $mobile=="") {
            $validationMessage .= "Mobile is mandatory field. </br>";
        }
        if($alternateMobile==null || $alternateMobile=="") {
            $validationMessage .= "Alternate mobile is mandatory field. </br>";
        }
        if( $state==0 || $state==null ||  $state=="") {
            $validationMessage .= " State is mandatory field. </br>";
        }
        if( $city==0 || $city==null ||  $city=="") {
            $validationMessage .= " City is mandatory field. </br>";
        }
        if( $ownerName==null ||  $ownerName=="") {
            $validationMessage .= " Owner Name is mandatory field. </br>";
        }
        if($EmailId==null ||  $EmailId=="") {
            $validationMessage .= " Email Id Name is mandatory field. </br>";
        }
        if($doctorId==null ||  count($doctorId)==0) {
            $validationMessage .= " Doctor Name is mandatory field. </br>";
        }
        if($validationMessage !== "") {
            $isError = true;
        }
        return ['error'=>$isError, 'message'=>$validationMessage];
    }

    public function updateCenter(Request $request,$centerId): JsonResponse {
        
        $center= Center::find($centerId)->update(
            [
                'centerDetails'=>$request->get("centerDetails"),
                'mobile'=>$request->get("mobile"),
                'alternateMobile'=>$request->get("alternateMobile"),
                'state'=>$request->get("state"),
                'city'=>$request->get("city"),
                'ownerName'=>$request->get("ownerName"),
                'EmailId'=>$request->get("EmailId"),
            ]
        );
        $doctorId = $request->get("roleId");
        if(isset($doctorId) && $center) {
            $ids = $request->get("roleId");
            $doctor= Doctors::whereIn("id", $ids)->update([
                'center_id' => $centerId
            ]);
        }
        if($center){
            return response()->json(['status'=>true, 'message'=>'Center updated successfully.']);
        }
        return response()->json(['status'=>true, 'message'=>'Some Error Occured']);
    }


    public function destroy(Request $request) : JsonResponse {
        $id = $request->get('id');
        Center::where('id', $id)->delete();

        return response()->json(['success' => 'Received rule data']);
    }

    public function checkDoctors(Request $request,$isEdit) : JsonResponse {

        $doctorIds =  $request->get('doctorIds');
        $centerId =   $request->get('centerId');
        $doctorsDetail = DB::table('doctors as d')
        ->select('d.*', 'c.centerDetails')
        ->join('centers as c', function($join){
            $join->on('d.center_id', '=', 'c.id');
        })->whereIn('d.id', $doctorIds)->get()->toArray();
        if($isEdit) {
            $doctorsDetail = DB::table('doctors as d')
            ->select('d.*', 'c.centerDetails')
            ->join('centers as c', function($join){
                $join->on('d.center_id', '=', 'c.id');
            })->whereIn('d.id', $doctorIds)->where('d.center_id', '!=' , $centerId)->get()->toArray();
        }
       
        return response()->json(['doctorsDetail' => $doctorsDetail]);        
    }
}

