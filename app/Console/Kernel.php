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
            Log::info($communicationSchedule->schedule);
            $schedule->command('processcommunicationschedules:cron', [$communicationSchedule])->cron($communicationSchedule->schedule);
        }
//        $schedule->command('openleadsassignment:cron')->everyMinute();
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
