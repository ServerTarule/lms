<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\LeadAssignmentService;
use App\Channels\WaclubWhatsApp;
class ApplyFollowUpRules extends Command
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
        Log::info('Reassigning leads using folloup cron...');

        $sql = "SELECT  * from follow_up_settings where follow_up_type = 2 order by follow_up_sequence ";
        $followUpSettings = DB::select($sql);

        // $followUpSettings = DB::table('follow_up_settings')->orderBy('follow_up_sequence')->get();
        Log::info("******followUpSettings start*******");
        Log::info(json_encode($followUpSettings)); 
        Log::info("*******setting end******");
        
        foreach ($followUpSettings as $setting) {
            Log::info("******setting start*******");
            Log::info(json_encode($setting)); 
            Log::info("*******setting end******");
            $this->processNonPromotionalFollowups($setting);
        }

    }
    private function processNonPromotionalFollowups($setting) {
        if ($setting->follow_up_rule_type == 'interval') {
            // Handle interval-based follow-up
            $this->reassignLeadsAfterDays($setting->follow_up_interval, $setting->follow_up_sequence);
        } elseif ($setting->follow_up_rule_type == 'monthly') {
            // Handle monthly follow-up
            $this->reassignLeadsContactedInMonth($setting->month_offset,$setting->follow_up_sequence);
        }
    }

    private function reassignLeadsContactedInMonth($monthOffset,$contactNumber)
    {
        $startDate = Carbon::now()->subMonths($monthOffset)->startOfMonth()->toDateString();
        $endDate = Carbon::now()->subMonths($monthOffset)->endOfMonth()->toDateString();

        $sql = "SELECT l.id, l.employee_id, lc.id as leadcall_id,
        lc.connected_at, lc.connected, lc.connection_number
        FROM leads l INNER JOIN leadcalls lc on l.id=lc.lead_id
        WHERE lc.connected = 1
        AND DATE(lc.connected_at) BETWEEN '$startDate' AND '$endDate'
        AND lc.connection_number= '$contactNumber'
        AND l.is_accepted = 1
        GROUP BY l.id, l.employee_id, lc.id, lc.connected_at, 
        lc.connected, lc.connection_number";

        Log::info("Query for MONTH and $contactNumber coneected term ==".$sql);

        $leads = DB::select($sql);
        Log::info('***  leads connected  ***for contactNumber****'.$contactNumber);
        Log::info($leads);
        Log::info('***  leads connected end ***for contactNumber**'.$contactNumber);

        $leadsArray = json_decode(json_encode($leads), true);
        if(count($leadsArray) > 0) {
            Log::info('***  employee_id****');
            Log::info( "employee_id".$leads[0]->employee_id."*********");
            $this->leadAssignmentService->assignOpenLeads($leads,0);
        }
    }
    private function reassignLeadsAfterDays($days, $contactNumber = 1)
    {
        
        $date = Carbon::now()->subDays($days)->toDateString();
        $sql = "SELECT l.id, l.employee_id, lc.id as leadcall_id,
        lc.connected_at, lc.connected, lc.connection_number
        FROM leads l INNER JOIN leadcalls lc on l.id=lc.lead_id
        WHERE lc.connected = 1
        AND DATE(connected_at) = '$date'
        AND lc.connection_number= '$contactNumber' 
        AND l.is_accepted = 1
        GROUP BY l.id, l.employee_id, lc.id, lc.connected_at, 
        lc.connected, lc.connection_number";

        Log::info("Query for $days day(s) and $contactNumber coneected term ==".$sql);

        $leads = DB::select($sql);
        Log::info('***  leads connected  ***for contactNumber****'.$contactNumber);
        Log::info($leads);
        Log::info('***  leads connected end ***for contactNumber**'.$contactNumber);

        $leadsArray = json_decode(json_encode($leads), true);
        if(count($leadsArray) > 0) {
            Log::info('***  employee_id****');
            Log::info( "employee_id".$leads[0]->employee_id."*********");
            $this->leadAssignmentService->assignOpenLeads($leads,0);
        }
    }
    
    /*
    private function processPromotionalFollowups($setting) {
        if ($setting->follow_up_rule_type == 'interval') {
            // Send Followup Promotional Message By Day
            $this->sendPromotionalMessages($setting);
           
        } elseif ($setting->follow_up_rule_type == 'monthly') {
            // Send Followup Promotional Message By Month
            $this->sendPromotionalMessages($setting);
            
        }
    }
*/

    /*
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
            $this->leadAssignmentService->assignOpenLeads($leads,0);
        }
    }
*/

    /*
    private function applyFollowUpRulesToLead($lead, $settings)
    {
        $followUpDates = json_decode($lead->follow_up_dates, true) ?: [];

        foreach ($settings as $setting) {
            $followUpNo = $setting->follow_up_sequence;
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
*/
/*
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
*/
/*
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
    */
}
