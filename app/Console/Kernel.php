<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //delete files that has no relation
        $schedule->command('untracked_files:delete')->daily();
        //telescope entries delete
        $schedule->command('telescope:clear')->daily();
        //create absent days (daily at 10 PM)
        $schedule->command('employees:check-absent')->dailyAt('22:00');
        //create deduction for absent (workDays at 11 PM)
        $schedule->command('deduction:auto-create')
            ->days([Schedule::SUNDAY,Schedule::MONDAY,Schedule::TUESDAY, Schedule::WEDNESDAY,Schedule::THURSDAY])
            ->at("23:00");
        //update sla active status
        $schedule->command('sla-records:outdated')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
