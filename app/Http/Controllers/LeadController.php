<?php

namespace App\Http\Controllers;

use App\Events\LeadReceived;
use App\Models\DynamicMain;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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
//        $leads = Lead::all();
        $leads = Lead::with(['leadmasters.master','leadmasters.mastervalue'])->get();
        foreach ($leads as $lead) {
//            Log::info($lead->leadmasters->master);
            foreach ($lead->leadmasters as $lm) {
                //Log::info($lm->master);
                //Log::info($lm->mastervalue);
            }
//            Log::info($lead->leadmasters->mastervalue->name);
        }

        return view('leads.call', compact('leads'));
    }

    public function assignment()
    {
        return view('leads.leadassignment');
    }

    public function upload()
    {
        return view('leads.leadupload');
    }


}
