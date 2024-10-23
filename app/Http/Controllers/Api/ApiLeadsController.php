<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DynamicValue;
use App\Models\DynamicMain;
use App\Models\Api\Lead;
use App\Models\LeadMaster;

class ApiLeadsController extends Controller
{

    //
    public function getLeadCountData(Request $request)
    {
        // $request->validated($request->aLL());
        if ($request->employee_id == "") {
            return [

                "status" => false,
                "message" => "Pass Employee Id"
            ];
        }


        $allLeadCount = Lead::where('employee_id', $request->employee_id)->count();
        $leadConnectedData = Lead::where('employee_id', $request->employee_id)->
            where('is_accepted', '1')->count();

        $superHotLeadIds = LeadMaster::where('mastervalue_id', '85')->pluck('lead_id');

        if ($superHotLeadIds->isNotEmpty()) {
            $superHotLeadCount = Lead::where('employee_id', $request->employee_id)
                ->whereIn('id', $superHotLeadIds)
                ->count();
        }

        $hotLeadIds = LeadMaster::where('mastervalue_id', '38')->pluck('lead_id');
        if ($hotLeadIds->isNotEmpty()) {
            $hotLeadCounts = Lead::where('employee_id', $request->employee_id)
                ->whereIn('id', $hotLeadIds)
                ->count();
        }

        if ($allLeadCount) {
            return [

                "status" => true,
                "message" => "Data Found",
                "allLeadCount" => $allLeadCount,
                "leadConnectedCount" => $leadConnectedData,
                "superHotLeadCount" => $superHotLeadCount,
                "hotLeadIds" => $hotLeadCounts
            ];
        } else {
            return [

                "status" => false,
                "message" => "Data not Found"
            ];
        }
    }


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

        if ($request->dependent_id == "") {
            return [

                "status" => false,
                "message" => "Pass Dependent Id"
            ];

        }
        // $request->validated($request->aLL());
        $leadTypeData = DynamicValue::
            where('dependent_id', $request->dependent_id)->get();
        //echo $leadTypeData;
        //exit();
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


    public function createNewLead(Request $request)
    {
        $leadData = new Lead();


        if ($request->employee_id == "") {
            return [

                "status" => false,
                "message" => "Pass Employee Id"
            ];
        } else if ($request->patinet_name == "") {
            return [

                "status" => false,
                "message" => "Pass Patient Name"
            ];
        } else if ($request->patinet_email == "") {
            return [

                "status" => false,
                "message" => "Pass Patient Email"
            ];
        } else if ($request->patinet_mobile == "") {
            return [

                "status" => false,
                "message" => "Pass Patient Mobile"
            ];
        } else if ($request->lead_received_date == "") {
            return [

                "status" => false,
                "message" => "Pass Lead Recevied Data"
            ];
        }
        //    else  if($request->lead_remark == ""){
        //     return [

        //         "status" => false,
        //         "message" => "Pass Employee Id"
        //     ];
        //    }

        $leadData->name = $request->patinet_name;
        $leadData->email = $request->patinet_email;
        $leadData->mobileno = $request->patinet_mobile;
        $leadData->altmobileno = $request->patinet_alternate_mobile;
        $leadData->receiveddate = $request->lead_received_date;
        $leadData->remark = $request->lead_remark;
        $leadData->employee_id = $request->employee_id;

        if ($leadData->save()) {

            $leadSavedId = $leadData->id;

            $masters = DynamicMain::where('master', '1')->count();
            $dataToInsert = [];
            $masterValues = $request->mastervalue_id;
            for ($x = 1; $x <= $masters; $x++) {
                $dataToInsert[] = [
                    'lead_id' => $leadSavedId,
                    'master_id' => $x,
                    'mastervalue_id' => isset($masterValues[$x - 1]) ? $masterValues[$x - 1] : 0,
                ];
            }
            LeadMaster::insert($dataToInsert);

            return [

                "status" => true,
                "message" => "Lead successfully created.!",
            ];

        } else {
            return [

                "status" => false,
                "message" => "Lead Not Added"
            ];
            // The model was not saved
            // Handle the error (e.g., log it, throw an exception, etc.)
        }

    }


    public function getLeadsByEmployeeId(Request $request)
    {


        if ($request->employee_id == "") {
            return [

                "status" => false,
                "message" => "Pass Employee Id"
            ];
        } else if ($request->whichLead == "all" || $request->whichLead == "") {

            $leadList = Lead::where('employee_id', $request->employee_id)->get();

        } else if ($request->whichLead == "superHot") {
            $superHotLeadIds = LeadMaster::where('mastervalue_id', '85')->pluck('lead_id');

            if ($superHotLeadIds->isNotEmpty()) {
                $leadList = Lead::where('employee_id', $request->employee_id)
                    ->whereIn('id', $superHotLeadIds)
                    ->get();
            }
        } else if ($request->whichLead == "hot") {
            $hotLeadIds = LeadMaster::where('mastervalue_id', '38')->pluck('lead_id');
            if ($hotLeadIds->isNotEmpty()) {
                $leadList = Lead::where('employee_id', $request->employee_id)
                    ->whereIn('id', $hotLeadIds)
                    ->get();
            }
        } else if ($request->whichLead == "connected") {
            $leadList = Lead::where('employee_id', $request->employee_id)->
                where('is_accepted', '1')->get();

        }

        if ($leadList->count() == 0) {

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


    public function getLeadsByDetailsByLeadId(Request $request)
    {


        if ($request->leadId == "") {
            return [

                "status" => false,
                "message" => "Pass Lead Id"
            ];

        }

        $leadData = Lead::where('id', $request->leadId)->get();
        if ($leadData->count() == 0) {
            return [

                "status" => false,
                "message" => "Data not Found"
            ];
        } else {

            $leadMasterData = LeadMaster::where('lead_id', $leadData[0]->id)->pluck('mastervalue_id');
            $dynamicValueData = [];
            $masters = []; // Initialize masters array

            if ($leadMasterData->isNotEmpty()) {
                $dynamicValueData = DynamicValue::whereIn('id', $leadMasterData)
                    ->pluck('name', 'id')
                    ->toArray();

                $masters = DynamicMain::where('master', '1')->pluck('name')->toArray(); // Fetch masters
            }

            $finalDynamicValueData = [];
            $mastersCount = count($masters);

            foreach ($leadMasterData as $index => $id) {
                if ($index < $mastersCount) {
                    $key = $masters[$index];

                    if (isset($dynamicValueData[$id])) {
                        $finalDynamicValueData[$key] = $dynamicValueData[$id];
                    } else {
                        $finalDynamicValueData[$key] = "NA";
                    }
                }
            }

            $leadDataArray = $leadData->first()->toArray();

            $responseData = array_merge($leadDataArray, $finalDynamicValueData);

            return [
                "status" => true,
                "message" => "Data Found",
                "data" => $responseData
            ];



        }

    }


    public function acceptLeadStatus(Request $request)
    {


        if ($request->leadId == "") {
            return [

                "status" => false,
                "message" => "Pass Lead Id"
            ];

        } else if ($request->employeeId == "") {
            return [

                "status" => false,
                "message" => "Pass Employee Id"
            ];

        } else if ($request->is_accepted == "") {
            return [

                "status" => false,
                "message" => "Pass Accepted Value Id"
            ];

        }

        $lead = Lead::where('employee_id', $request->employeeId)->
            where('id', $request->leadId)->first();
        if (!$lead) {
            return response()->json([
                'status' => false,
                'message' => 'Lead not found'
            ], 200);
        }

        $lead->is_accepted = $request->is_accepted;
        $lead->save();

        return response()->json([
            'status' => true,
            'message' => 'Lead Update Success'
        ], 200);

    }

}
