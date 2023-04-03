<?php

namespace App\Http\Controllers;

use App\Events\LeadReceived;
use App\Exports\LeadsExport;
use App\Imports\LeadsImport;
use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isNull;

class LeadController extends Controller
{
    public function index() : View
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    public function create() : View
    {
        $masters = DynamicMain::all();
        return view('leads.create', compact('masters'));
    }

    public function store(Request $request) : JsonResponse {

        $name = $request->get('name');
        $email = $request->get('email');
        $mobileno = $request->get('mobileno');
        $altmobileno = $request->get('altmobileno');
        $receiveddate = $request->get('receiveddate');
        $remark = $request->get('remark');

        $leadMasterData = $request->get('leadMasterData');

        $lead = Lead::create([
            'name' => $name,
            'email' => $email,
            'mobileno' => $mobileno,
            'altmobileno' => $altmobileno,
            'receiveddate' => $receiveddate,
            'remark' => $remark]
        );

        $leadId = $lead->id;

        $leadMasters = json_decode( $leadMasterData, true );

        foreach($leadMasters as $leadMaster) {

            $masterId = $leadMaster['master'];
            $masterValueId = $leadMaster['masterValue'];

            $dataItem = [];
            $dataItem['lead_id'] = $leadId;
            $dataItem['master_id'] = $masterId;
            $dataItem['mastervalue_id'] = $masterValueId;

            LeadMaster::unguard();
            LeadMaster::create($dataItem);
            LeadMaster::reguard();

        }

        LeadReceived::dispatch($lead);

        return response()->json(['success' => 'Received rule data']);
    }

    public function call()
    {
        $leads = Lead::all();
        $leadMasterNames = array();
        foreach ($leads as $key=>$value) {
            $leadMasters = LeadMaster::where('lead_id', $value->id)->get();
            $leads[$key]['leadmasters'] = $leadMasters;
            foreach ($leadMasters as $k=>$v) {
                $masters = DynamicMain::where('id', $v->master_id)->get();
                foreach ($masters as $master) {
                    $leadMasters[$k]['master'] = $master;
                    $leadMasterNames[] = $master->name;
                }
//                $leadMasters['masters'] = $masters;
                $mastervalues = DynamicValue::where('id', $v->mastervalue_id)->get();
                foreach ($mastervalues as $mastervalue) {
                    $leadMasters[$k]['mastervalue'] = $mastervalue;
                }
//                $leadMasters['$mastervalues'] = $mastervalues;
            }
        }
//        Log::info($leads);
        foreach ($leads as $lead) {
//            Log::info($lead['leadMasters']);
            foreach ($lead['leadmasters'] as $leadMaster) {
//                Log::info($leadMaster->master->name);
//                Log::info($leadMaster->mastervalue);
            }
        }

        $uniqueLeadMasterNames = array_unique($leadMasterNames);
//        Log::info($uniqueLeadMasterNames);

//        foreach ($leads as $lead) {
//            $leadMasters = $lead->leadmasters()->get();
//            foreach ($leadMasters as $leadMaster) {
//                $master = $leadMaster->master;
//                $masterValue = $leadMaster->mastervalue;
//
////                Log::info($master);
//
//                if (!is_null($master)) {
//                    Log::info($master);
//                }
//
//                if (!is_null($masterValue)) {
//                    Log::info('Master Value: ' . ' ' . $masterValue->name);
//                }
//            }
//        }
//        Log::info($leads);
//        Log::info('*** Array ***');
//        $leadsArray = $leads->toArray();
//        Log::info($leadsArray);
//        foreach ($leadsArray as $lead) {
//            $lead['leadmasters'] = $lead->leadmasters()->get()->toArray();
//         }
//        Log::info($leadsArray);
        return view('leads.call', compact('leads', 'uniqueLeadMasterNames'));
    }

    public function assignment()
    {
        return view('leads.leadassignment');
    }

    public function upload(Request $request)
    {
        Excel::import(new LeadsImport, $request->file('file')->store('temp'));
        return back();
    }

    public function export() {
        return Excel::download(new LeadsExport, 'Leads_'.date("d-m-Y H:i:s", time()).'.xlsx');
    }


}
