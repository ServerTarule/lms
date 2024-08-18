<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Channels\WaclubWhatsApp;
class SendPromotionalAndReminderMessages extends Command
{
    protected $signature = 'apply:send-promotional-and-reminder-messages';

    protected $description = 'Send promotional and reminder messages based on follow-up settings';

    protected $leadAssignmentService;
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info("******SendPromotionalAndReminderMessages start*******");

        $sql = "SELECT  * from follow_up_settings where follow_up_type =1 order by follow_up_sequence ";
        $followUpSettings = DB::select($sql);       
        foreach ($followUpSettings as $setting) {
            Log::info("******setting start*******");
            Log::info(json_encode($setting)); 
            Log::info("*******setting end******");
            // Log::info($setting);
          $this->sendReminderMessages($setting);
        }
    }


    private function sendReminderMessages($setting)
    {
        $sql = "SELECT id, parent_id from dynamic_values where use_for_reminder=1";
        $dynamicValues = DB::select($sql);
        Log::info('***  dynamicValues****');
        Log::info( $dynamicValues);
        $dynamicMasterIds = [];
        $count = count($dynamicValues);
        Log::info("===count===".count($dynamicValues));
        $dynamicMasterIdsStr = "(";
        foreach($dynamicValues as $k=>$dynamicValue) {
            array_push($dynamicValues,$dynamicValue->id);
            $dynamicMasterIdsStr.= "'".$dynamicValue->id."'";
            Log::info('$k==='.$k);
            if($k < $count-1) {
                $dynamicMasterIdsStr.= ',';
            }    
        }
        $dynamicMasterIdsStr.= ")";
        Log::info(json_encode($dynamicMasterIds));
        Log::info($dynamicMasterIdsStr);
        $leadsSql = "SELECT l.*, lm.id as lead_master_id, e.id as emp_id, e.name, e.contact from leads l inner join leadmasters lm ON l.id = lm.lead_id INNER JOIN employees e on l.employee_id=e.id where lm.mastervalue_id IN $dynamicMasterIdsStr and  DATEDIFF(CURDATE(), l.updated_at) > $setting->follow_up_interval";
        Log::info($leadsSql);
        $leads = DB::select($leadsSql);
        Log::info('***  leads****');
        Log::info($leads);
        $getTemplateSql ="SELECT * from templates where template_type='Reminder' and isCurrent=1";
        $template = DB::select($getTemplateSql);
        Log::info('***  template****');
        Log::info($template);
        $message =  "";
        if(isset($template[0])) {
            $message = $template[0]->message;
        }
        foreach($leads as $lead) {
            if($message && $lead->contact) {
                Log::info('***  going to send reminder****');
                WaclubWhatsApp::sendMessage('+91'.$lead->contact,$message);
            }
        }
    }
}
