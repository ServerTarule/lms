<?php

namespace App\Http\Controllers;

use App\Events\LeadReceived;
use App\Exports\LeadsExport;
use App\Imports\LeadsImport;
use App\Mail\Campaign;
use App\Models\Communication;
use App\Models\DynamicMain;
use App\Models\DynamicValue;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadCall;
use App\Models\LeadMaster;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\State;
use App\Models\Template;
use App\Notifications\LeadConnect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isNull;

class LeadController extends Controller
{
    public function index() : View
    {
        $leads = Lead::all();
        //Get all Masters
        $masters=DynamicMain::where('master', '1')->get();
        return view('leads.index', compact('leads', 'masters'));
    }

    public function show($id) : View
    {
        $lead = Lead::where('id', $id)->get();
        $leadmaster = LeadMaster::where('lead_id', $id)->get();
        $leadKV = array();
        foreach ($lead as $l) {
            $leadKV['Name'] = $l->name;
            $leadKV['Mobile No.'] = $l->mobileno;
            $leadKV['Alternate Mobile No.'] = $l->altmobileno;
            $leadKV['Email Id'] = $l->email;
        }
        foreach ($leadmaster as $lm) {
            $leadKV[$lm->master->name] = $lm->mastervalue?->name;
        }
        foreach ($lead as $l) {
            $leadKV['Received Date'] = date("d/m/Y", strtotime($l->receiveddate));
        }
        return view('leads.show', compact('leadKV'));
    }

    public function showtoedit($id) : JsonResponse {
        $lead = Lead::find($id);
        $leadmasters = LeadMaster::where('lead_id', $id)->get();
        //Get all Masters
        $masters=DynamicMain::where('master', '1')->get();
        return response()->json([
            'lead' => $lead,
            'leadmasters' => $leadmasters,
            'success' => 'Received rule data'
        ]);
    }

    public function create() : View
    {
        $masters=DynamicMain::where('master', '1')->get();
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

    public function updateone(Request $request) : RedirectResponse
    {

        $leadId = $request->get('leadId');

        $lead = Lead::find($leadId);
        $lead->name = $request->get('leadName');
        $lead->email = $request->get('leadEmail');
        $lead->mobileno = $request->get('leadMobile');
        $lead->altmobileno = $request->get('leadAlternateMobile');
        $lead->save();

        $leadMasters = LeadMaster::where('lead_id', $leadId)->orderBy('master_id', 'ASC')->get();
        foreach ($leadMasters as $key => $value) {
            $value->mastervalue_id = $request->get('leadMaster_'.$key+1);
            $value->save();
        }

        $leads = Lead::all();
        //Get all Masters
        $masters=DynamicMain::where('master', '1')->get();
        return redirect()->route('leads.index', compact('leads', 'masters'));
    }

    public function call() : View
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

        //TODO Hard coded name to get master values
        $leadStatus =DynamicMain::where('name', 'Lead Status')->first();
        $leadStatuses = DynamicValue::where('parent_id', $leadStatus->id)->get();
        return view('leads.call', compact('leads', 'uniqueLeadMasterNames', 'leadStatuses'));
    }

    public function showcall($id) : View
    {
        $leads = Lead::where('id', $id)->get();
        $leadmaster = LeadMaster::where('lead_id', $id)->get();
        $leadKV = array();
        $leadKVForEdit = array();
        foreach ($leads as $l) {
            $leadKV['name'] = $l->name;
            $leadKV['mobileno'] = $l->mobileno;
            $leadKV['email'] = $l->email;
        }
        $leadMasters = array();
        foreach ($leadmaster as $lm) {
            $leadMasters[$lm->master_id] = $lm->mastervalue_id;
            $leadKV[$lm->master->name] = $lm->mastervalue?->name;
        }

        $leadId = null;

        foreach ($leads as $l) {
            $leadId = $l->id;
            $leadKVForEdit['id'] = $l->id;
            $leadKVForEdit['name'] = $l->name;
            $leadKVForEdit['email'] = $l->email;
            $leadKVForEdit['mobileno'] = $l->mobileno;
            $leadKVForEdit['altmobileno'] = $l->altmobileno;
            $leadKVForEdit['receiveddate'] = $l->receiveddate;
            $leadKVForEdit['remark'] = $l->remark;
        }
        foreach ($leadmaster as $lm) {
            $leadKVForEdit[$lm->master->name] = $lm->mastervalue?->name;
        }

        $employees = Employee::all();

        //Send Email
        $emailTemplates = Template::where('type', 'Email')->get();

        //Send WhatsApp
        $whatsappTemplates = Template::where('type', 'WhatsApp')->get();

        //Lead Calls
        $leadCalls = LeadCall::where('lead_id', $leadId)->orderBy('created_at', 'DESC')->get();

        //Get all Masters
        $masters=DynamicMain::where('master', '1')->get();

        return view('leads.showcall', compact('leads', 'leadKV', 'employees', 'emailTemplates', 'whatsappTemplates', 'leadCalls', 'leadKVForEdit', 'masters', 'leadMasters'));
    }

    public function update(Request $request): RedirectResponse {

        $leadId = $request->get('leadId');

        $lead = Lead::find($leadId);
        $lead->name = $request->get('leadName');
        $lead->email = $request->get('leadEmail');
        $lead->mobileno = $request->get('leadMobile');
        $lead->altmobileno = $request->get('leadAlternateMobile');
        $lead->remark = $request->get('leadRemark');
        $lead->save();

        $leadMasters = LeadMaster::where('lead_id', $leadId)->orderBy('master_id', 'ASC')->get();
        foreach ($leadMasters as $key => $value) {
            $value->mastervalue_id = $request->get('leadMaster_'.$key+1);
            $value->save();
        }

        return redirect()->route('leads.showcall', $leadId);
    }

    public function email(Request $request) : JsonResponse {

        $leadId = $request->get('leadId');
        $employeeId = $request->get('employeeId');
        $templateId = $request->get('templateId');
        $emailId = $request->get('emailId');
        $type = $request->get('type');
        $remark = $request->get('remark');
        $reminderDate = $request->get('reminderDate');
        $template = Template::where('id', $templateId)->first();

//        //TODO: Connected via Email
//        $emailConnect = DynamicValue::where('name', 'Connected via Email')->first();

        $leadCall = LeadCall::create([
            'type' => $type,
            'lead_id'=>$leadId,
            'employee_id'=>$employeeId,
            'leadstatus_id'=>null,
            'remark'=>$remark,
            'called_at'=>now(),
            'remind_at'=>$reminderDate
        ]);

        Lead::where('id', $leadId)->update(['employee_id' => $employeeId]);

        Mail::to($emailId)->send(new Campaign($template));

        return response()->json(['success' => 'Email sent']);
    }

    public function whatsapp(Request $request) : JsonResponse {

        $leadId = $request->get('leadId');
        $employeeId = $request->get('employeeId');
        $templateId = $request->get('templateId');
        $mobileno = $request->get('mobileno');
        $type = $request->get('type');
        $callStatusId = $request->get('callStatusId');
        $remark = $request->get('remark');
        $reminderDate = $request->get('reminderDate');
        $template = Template::where('id', $templateId)->first();

//        //TODO: Connected on WhatsApp
//        $whatsappConnect = DynamicValue::where('name', 'Connected on WhatsApp')->first();

        $leadCall = LeadCall::create([
            'type' => $type,
            'lead_id'=>$leadId,
            'employee_id'=>$employeeId,
            'leadstatus_id'=>null,
            'callstatus_id'=>$callStatusId,
            'remark'=>$remark,
            'called_at'=>now(),
            'remind_at'=>$reminderDate
        ]);

        Lead::where('id', $leadId)->update(['employee_id' => $employeeId]);

        $lead = Lead::where('id', $leadId)->first();

        Notification::send($lead, new LeadConnect($lead));

        return response()->json(['success' => 'WhatsApp message sent']);
    }

    public function followup() : View {
        return view('leads.followup');
    }

    public function assignment() : View
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
