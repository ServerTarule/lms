<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Rule;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\CronTranslator\CronTranslator;

class CommunicationController extends Controller
{
    public function index()
    {
        $rules = Rule::all();
        $templates = Template::all();
        $communications = Communication::all();
        return view('communications.index', compact('rules', 'templates', 'communications'));
    }

    public function store(Request $request) : RedirectResponse {

        Log::info($request);

        $communicationTemplateType = $request->communicationTemplateType;
        $communicationTemplateId = $request->communicationTemplateId;
        $communicationTemplateMessage = $request->communicationTemplateMessage;
        $communicationTemplateSubject = $request->communicationTemplateSubject;
        $communicationTemplateBody = $request->Comments;

        $scheduleUnit = $request->scheduleUnit;
        $dayOfWeek = $request->dayOfWeek;
        $dayOfMonth = $request->dayOfMonth;

        $ruleId = $request->ruleId;

        $minuteHour = $request->minuteHour;
        $schedule = null;

        if ($scheduleUnit == 'DAILY') {
            $dayOfWeek = "*";
            $dayOfMonth = "*";
        }

        if ($scheduleUnit == 'WEEKLY') {
            $dayOfMonth = "*";
        }

        if(!is_null($minuteHour)) {
            $hour = substr($minuteHour, 0, 2);
            $min = substr($minuteHour, 3, 2);
            $schedule = $min.' '.$hour.' '.$dayOfMonth.' '.'*'.' '.$dayOfWeek;
        }

        $words = CronTranslator::translate($schedule);

//        Log::info($minuteHour);
//        Log::info($schedule);

        //0 0 * * *
        //MIN HR DAY-OF-MONTH MONTH DAY-OF-WEEK

        $communicationSchedule = Communication::create([
            'type'=>$communicationTemplateType,
            'message'=>$communicationTemplateMessage,
            'subject'=>$communicationTemplateSubject,
            'content'=>$communicationTemplateBody,
            'schedule'=>$schedule,
            'words'=>$words,
            'template_id'=>$communicationTemplateId,
            'rule_id'=>$ruleId
        ]);

        $communications = Communication::all();
        return redirect()->route('communications.index', compact('communications'));

    }
}
