<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use OwenIt\Auditing\Audit;
use OwenIt\Auditing\Auditable;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
/*    public function index() : View
    {
        $lead = Lead::find(1);
        $masters = LeadMaster::where('lead_id', $lead->id)->where('mastervalue_id', '<>', null)->get();
        $masterAudits = [];
        foreach ($masters as $master) {
            $ma = LeadMaster::find($master->id)->audits->where('tags', '1');
            if (count($ma) != 0) {
                $masterAudits[] = $ma;
            }
        }

        foreach ($masterAudits as $audit) {
            foreach ($audit as $a) {
                Log::info($a);
                Log::info($a->getMetadata(true));
                Log::info($a->getModified(true));
            }
        }

        $all = $lead->audits()->get();
        return view('logs.index', compact('all'));
    }*/

    public function index(): View {
/*        $leads = Lead::with('audits')->get();
        Log::info($leads);
        foreach ($leads as $lead) {
            $auditDecode = json_decode($lead['audits'], true);
            $auditDecode[] = ['firstname' => 'Prasad', 'lastname' => 'Supekar'];
            //$auditEncode = json_encode($auditDecode, JSON_UNESCAPED_SLASHES);
            //$lead['audits'] = $leadEncode;
            $leadDecode = json_decode($lead, true);
            //$leadDecode['audits'] = $auditEncode;
            $leadDecode['audits'] = $auditDecode;
            $leadEncode = json_encode($leadDecode, JSON_UNESCAPED_SLASHES);
//            $leadE = str_replace('\"', '"', json_encode($leadD['audits'], JSON_UNESCAPED_SLASHES));
            //$leadE = str_replace(array('\"',"\\\\\\\\"), array('"',"\\"), json_encode($leadD['audits'], JSON_UNESCAPED_SLASHES));
            //$leadEncode = str_replace(array('\"',"\\\\\\\\"), array('"',"\\"), $leadEncode);
            Log::info($leadEncode);
        }*/
//        Log::info($leads);
/*        $leads = Lead::all();
        foreach ($leads as $lead) {
            Log::info($lead->audits);
            $id = $lead->id;
            $leadmasters = LeadMaster::where('lead_id', $id)->get();
            foreach ($leadmasters as $leadmaster) {
                Log::info($leadmaster->audits->where('tags', '1'));
            }
        }*/

        $leads = Lead::with('audits')->get();
//        $leadaudits = [];
        $audits = [];
        foreach ($leads as $lead) {
            $auditDecode = json_decode($lead['audits'], true);
            $leadmasters = LeadMaster::where('lead_id', $lead->id)->get();
            foreach ($leadmasters as $leadmaster) {
                $leadMasterAudits = $leadmaster->audits
                    ->where('tags', $lead->id)
                    /*->where('new_values', 'not like','%null%')*/;
                Log::info($leadMasterAudits);
                foreach ($leadMasterAudits as $leadMasterAudit) {
                    $auditDecode[] = $leadMasterAudit;
                }
            }
            $leadDecode = json_decode($lead, true);
            $leadDecode['audits'] = $auditDecode;
            $leadEncode = json_encode($leadDecode, JSON_UNESCAPED_SLASHES);
//            $leadaudits[] = $leadEncode;

            $audit = [];
            $audit['id'] = $leadDecode['id'];
            //Log::info($leadDecode['audits']);
            $leadAuditData = $leadDecode['audits'];

            $oldValuesData = [];
            foreach ($leadAuditData as $auditData) {
                $oldData = $auditData['old_values'];
                foreach ($oldData as $key => $value) {
                    $oldValuesData[$key] = $value;
                }
            }
//            Log::info($oldValuesData);
            $audit['old'] = $oldValuesData;

            $newValuesData = [];
            foreach ($leadAuditData as $auditData) {
                $newData = $auditData['new_values'];
                foreach ($newData as $key => $value) {
                    $newValuesData[$key] = $value;
                }
            }
//            Log::info($newValuesData);
            $audit['new'] = $newValuesData;
//            Log::info($audit);
            $audits[] = $audit;

        }

//        foreach ($leadaudits as $key => $value) {
//            $lead = json_decode($value);
//            $audits = $lead->audits;
//            foreach ($audits as $audit) {
//                Log::info($audit->old_values);
//            }
//        }
        Log::info($audits);
        return view('logs.index', compact('audits'));
    }

    public function show($id) : View
    {
        $lead = Lead::find($id);
        $masters = LeadMaster::where('lead_id', $lead->id)->where('mastervalue_id', '<>', null)->get();
        $masterAudits = [];
        foreach ($masters as $master) {
            $masterAudit = LeadMaster::find($master->id)->audits->where('tags', $id);
            if (count($masterAudit) != 0) {
                $masterAudits[] = $masterAudit;
            }
        }

        foreach ($masterAudits as $audit) {
            foreach ($audit as $a) {
//                Log::info($a->user_type);
//                Log::info($a->old_value->mastervalue_id->old);
//                Log::info($a->new_value->mastervalue_id->new);
//                Log::info($a->getMetadata(true));
//                Log::info($a->getModified(true));
            }
        }

        $logs = null;

        $all = $lead->audits()->get();
        return view('logs.index', compact('logs'));
    }
}
