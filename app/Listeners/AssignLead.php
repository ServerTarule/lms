<?php

namespace App\Listeners;

use App\Events\LeadReceived;
use App\Models\Employee;
use App\Models\Lead;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class AssignLead
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LeadReceived  $event
     * @return void
     */
    public function handle(LeadReceived $event) : void
    {
        $lead = $event->lead;

        $employee = Employee::orderBy('lead_assigned_at','ASC')->first();

        $employeeId = $employee->id;

        Lead::where('id', $lead->id)->update(['employee_id' => $employeeId]);
        $date = date('Y-m-d\TH:i:s.uP', time());
        Employee::where('id', $employeeId)->update(['lead_assigned_at' => $date]);

    }

    /**
     * Handle a job failure.
     */
    public function failed(LeadReceived $event, Throwable $exception): void
    {
        // ...
    }
}
