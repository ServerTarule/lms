<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


use App\Models\Employee;
use App\Models\EmployeeRule;
use App\Models\Lead;
use App\Models\LeadMaster;
use App\Models\RuleCondition;
use App\Models\Leaves;
use App\Models\GlobalSetting;
use App\Services\LeadAssignmentService;

class ApplyFollowUpRules19Aug24 extends Command
{
    protected $signature = 'apply:follow-up-rules';

    // protected $signature = 'leads:reassign';
    protected $description = 'Apply follow-up rules to leads based on follow-up settings';

    protected $leadAssignmentService;
    public function __construct(LeadAssignmentService $leadAssignmentService)
    {
        parent::__construct();
        $this->leadAssignmentService = $leadAssignmentService;

    }

    public function handle()
    {
        print_r("---I am printing---");
        Log::info('***  employeeRules printing***');
        $this->info('Reassigning leads...');

        // Rule 1: Reassign 3 days after the first contact
       $this->reassignLeadsAfterDays(3);

        // Rule 2: Reassign 5 days after the second contact
       $this->reassignLeadsAfterDays(5, 2);

        // Rule 3: Reassign 10 days after the third contact
        $this->reassignLeadsAfterDays(10, 3);

        // Rule 4: Reassign leads contacted last month
        $this->reassignLeadsContactedLastMonth();

        // Rule 5: Send promotional WhatsApp message every 15 days
        $this->sendPromotionalMessages();

        $this->info('Leads reassigned successfully.');
        // // Fetch all follow-up settings
        // $settings = DB::table('follow_up_settings')->orderBy('follow_up_no')->get();

        // // Fetch all leads that need follow-ups
        // $leads = DB::table('leads')->get();

        // foreach ($leads as $lead) {
        //     $this->applyFollowUpRulesToLead($lead, $settings);
        // }

        // $this->info('Follow-up rules applied successfully.');
    }

    private function reassignLeadsAfterDays($days, $contactNumber = 1)
    {
        // Log::info('***  days  ***');
        // Log::info($days);
        // Log::info('***  days end ***');

        // Log::info('***  contactNumber  ***');
        // Log::info($contactNumber);
        // Log::info('***  contactNumber end ***');

        // Log::info('***  Carbon::now()  ***');
        // Log::info(Carbon::now());
        // Log::info('***  Carbon::now() end ***');

        $date = Carbon::now()->subDays($days)->toDateString();
        // Log::info('*** connected_at date  ***');
        // Log::info($date);
        // Log::info('*** connected_at date end ***');
        $date = Carbon::now()->subDays($days)->toDateString();
        $sql = "SELECT l.id, l.employee_id, lc.id as leadcall_id,
        lc.connected_at, lc.connected, lc.connection_number
        FROM leads l INNER JOIN leadcalls lc on l.id=lc.lead_id
        WHERE lc.connected = 1
        AND DATE(connected_at) = '$date'
        AND lc.connection_number= '$contactNumber' 
        AND l.is_accepted = 0
        GROUP BY l.id, l.employee_id, lc.id, lc.connected_at, 
        lc.connected, lc.connection_number";

        Log::info("Query for $days daya and $contactNumber coneected term ==".$sql);

        $leads = DB::select($sql);
        // $leads = DB::table('leadcalls')
        //     ->where('connected', '=', true)
        //     ->whereDate(DB::raw('DATE(connected_at)'), '=', $date)
        //     ->groupBy('lead_id')
        //     ->pluck('lead_id');

        Log::info('***  leads connected  ***for contactNumber****'.$contactNumber);
        Log::info($leads);
        Log::info('***  leads connected end ***for contactNumber**'.$contactNumber);

        $leadsArray = json_decode(json_encode($leads), true);

        Log::info('***  employee_id****');
        Log::info( "employee_id".$leads[0]->employee_id."*********");
        // Log::info('***  leadsArray**'.count($leadsArray));
        if(count($leadsArray) > 0) {
            $this->leadAssignmentService->assignOpenLeads($leads);
        }
    }


    private function reassignLeadsContactedLastMonth()
    {
        $date = Carbon::now()->subMonth();
        Log::info('***  date  ***');
        Log::info($date);
        Log::info('***  date end ***');

        $sql = "SELECT l.id, l.employee_id, lc.id as leadcall_id,
        lc.connected_at, lc.connected, lc.connection_number
        FROM leads l INNER JOIN leadcalls lc on l.id=lc.lead_id
        WHERE lc.connected = 1
        AND MONTH(`connected_at`) =  $date->month
        AND YEAR(`connected_at`) = $date->year
        AND l.is_accepted = 1
        GROUP BY l.id, l.employee_id, lc.id, lc.connected_at, 
        lc.connected, lc.connection_number";

        Log::info("Query for reassignLeadsContactedLastMonth  ==".$sql);

        $leads = DB::select($sql);
        Log::info("**************leads in last month**********");
        Log::info($leads);
        Log::info("**************leads in last month**********");

        $leadsArray = json_decode(json_encode($leads), true);

        // Log::info('***  leadsArray****');
        // Log::info($leadsArray);
        // Log::info('***  leadsArray**'.count($leadsArray));

        if(count($leadsArray) > 0 && isset($leads[0]->employee_id)) {
            $this->leadAssignmentService->assignOpenLeads($leads);
        }
    }

    private function sendPromotionalMessages()
    {
        $date = Carbon::now()->subMonth();
        $leads = DB::table('leads')
            ->whereIn('state', ['Warm', 'Cold'])
            ->whereDate('receiveddate', '<=', $date)
            ->pluck('id');

        // foreach ($leads as $lead_id) {
        //     $this->sendWhatsAppMessage($lead_id);
        // }
        $leadsArray = json_decode(json_encode($leads), true);

        // Log::info('***  leadsArray****');
        // Log::info($leadsArray);
        // Log::info('***  leadsArray**'.count($leadsArray));

        if(count($leadsArray) > 0 && isset($leads[0]->employee_id)) {
            $this->leadAssignmentService->assignOpenLeads($leads);
        }
    }

    private function reassignLead($lead_id)
    {
        $lead = Lead::find($lead_id);
        if ($lead) {
            $employees = Employee::all();
            $employee = $employees->random();
            $lead->employee_id = $employee->id;
            $lead->save();
        }
    }
    
    private function applyFollowUpRulesToLead($lead, $settings)
    {
        $followUpDates = json_decode($lead->follow_up_dates, true) ?: [];

        foreach ($settings as $setting) {
            $followUpNo = $setting->follow_up_no;
            $intervalDays = $setting->follow_up_interval;
            $followUpType = $setting->follow_up_type;

            if (!isset($followUpDates[$followUpNo])) {
                $followUpDates[$followUpNo] = $this->calculateFollowUpDate($lead, $followUpDates, $followUpNo, $intervalDays);
            }

            if (Carbon::parse($followUpDates[$followUpNo])->isPast()) {
                $this->sendFollowUpMessage($lead, $followUpType);
                $followUpDates[$followUpNo] = Carbon::now()->toDateTimeString();
            }
        }

        // Update the lead's follow_up_dates
        DB::table('leads')->where('id', $lead->id)->update(['follow_up_dates' => json_encode($followUpDates)]);
    }

    private function calculateFollowUpDate($lead, $followUpDates, $followUpNo, $intervalDays)
    {
        // Calculate the follow-up date based on the previous follow-up date or lead received date
        if ($followUpNo == 1) {
            return Carbon::parse($lead->receiveddate)->addDays($intervalDays)->toDateTimeString();
        } else {
            $previousFollowUpNo = $followUpNo - 1;
            return Carbon::parse($followUpDates[$previousFollowUpNo])->addDays($intervalDays)->toDateTimeString();
        }
    }

    private function sendFollowUpMessage($lead, $followUpType)
    {
        // Implement the logic to send a promotional or non-promotional message
        // This can be an email, SMS, or any other form of communication
        if ($followUpType == 1) {
            echo "Send non promotional message";
            // Send non-promotional message
        } else {
            // Send promotional message
            echo "Send promotional message";
        }

        // Log the follow-up
        DB::table('lead_followups')->insert([
            'lead_id' => $lead->id,
            'user_id' => $lead->employee_id,
            'followed_up_at' => Carbon::now(),
            'followup_status' => $followUpType == 1 ? 'Non-Promotional' : 'Promotional'
        ]);
    }

    private function sendWhatsAppMessage($lead_id)
    {
        // Implement your WhatsApp messaging logic here
    }
}
