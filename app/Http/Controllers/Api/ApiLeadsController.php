<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DynamicValue;
use App\Models\Api\Lead;
class ApiLeadsController extends Controller
{

    //
    public function getLeadTypes(Request $request)
    {
        // $request->validated($request->aLL());
        $leadTypeData = DynamicValue::where('parent_id', $request->lead_id)->get();
        
        if ($leadTypeData == null) {
            return [

                "status" => false,
                "message" => "Data not Found"
            ];
        } else {
            return [

                "status" => true,
                "message" => "Data Found",
                "data" => $leadTypeData
            ];
        }
    }


    public function getDependentLeadTypes(Request $request)
    {

        if($request->lead_id == ""){
            return [
    
                "status" => false,
                "message" => "Pass Lead Id"
            ];
           }else if($request->dependent_id == ""){
            return [
    
                "status" => false,
                "message" => "Pass Dependent Id"
            ];
    
           }
        // $request->validated($request->aLL());
        $leadTypeData = DynamicValue::where('parent_id', $request->lead_id)->
        where('dependent_id',$request->dependent_id)->toSql();
        echo $leadTypeData;
        exit();
        if ($leadTypeData == null) {
            return [

                "status" => false,
                "message" => "Data not Found"
            ];
        } else {
            return [

                "status" => true,
                "message" => "Data Found",
                "data" => $leadTypeData
            ];
        }
    }

    public function createNewLead(Request $request){

        if($request->employee_id == ""){
            return [
    
                "status" => false,
                "message" => "Pass Employee Id"
            ];
           }

    }


    public function getLeadsByEmployeeId(Request $request){

      
       if($request->employee_id == ""){
        return [

            "status" => false,
            "message" => "Pass Employee Id"
        ];
       }else if($request->leadparentId == ""){
        $leadList = Lead::where('employee_id', $request->employee_id)->get();

       }


       
        if ($leadList == null) {
            return [

                "status" => false,
                "message" => "Data not Found"
            ];
        } else {
            return [

                "status" => true,
                "message" => "Data Found",
                "data" => $leadList
            ];
        }

    }
    
}
