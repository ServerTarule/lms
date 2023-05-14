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
    public function index() : View
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
    }

    public function leadlogs($id) : View
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
                Log::info($a->user_type);
                Log::info($a->old_value->mastervalue_id->old);
                Log::info($a->new_value->mastervalue_id->new);
//                Log::info($a->getMetadata(true));
//                Log::info($a->getModified(true));
            }
        }

        $logs = null;

        $all = $lead->audits()->get();
        return view('logs.index', compact('logs'));
    }
}
