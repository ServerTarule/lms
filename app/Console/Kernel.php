<?php

namespace App\Console;

use App\Console\Commands\OpenLeadsAssignment;
use App\Models\Communication;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        OpenLeadsAssignment::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $communicationSchedules = Communication::all();
        foreach ($communicationSchedules as $communicationSchedule) {
            
            if ($communicationSchedule->schedule != 'now') {
                // echo "Going to print schedule";
                // print_r($communicationSchedule->schedule);
                // echo "Going to print schedule";
                // print_r($communicationSchedule->schedule);
                $schedule->command('processcommunicationschedules:cron', [$communicationSchedule])->cron($communicationSchedule->schedule);
            }
        }
        $schedule->command('openleadsassignment:cron')->everyMinute();

        $schedule->command('apply:follow-up-rules')->everyMinute(); // When it will go live it will run on every day basis

        // $schedule->command('apply:send-promotional-and-reminder-messages')->everyMinute(); // When it will go live it will run on every day basis

        $schedule->command('apply:send-promotional-and-reminder-messages')->twiceMonthly(
            1, 20,'02:28'
        );// When it will go live it will run on every fortnight say on 1st of month at 00:00 and at 16 of month at 00:00
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
