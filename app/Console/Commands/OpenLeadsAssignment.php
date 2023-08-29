<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OpenLeadsAssignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openleadsassignment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open Leads Assignment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("CRON JOB - I am being called every minute");
        Log::info("CRON JOB - Open Leads Assignment");
        $openLeads = Lead::whereNull('employee_id')->get();
        Log::info($openLeads);
        foreach ($openLeads as $openLead) {
            $employee = Employee::orderBy('lead_assigned_at', 'ASC')->first();
            $employeeId = $employee->id;

            Lead::where('id', $openLead->id)->update(['employee_id' => $employeeId]);
            $date = date('Y-m-d H:i:s');//'2023-08-13 20:12:33';//date('Y-m-d\TH:i:s.uP', time());
            Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);
        }
    }
}
