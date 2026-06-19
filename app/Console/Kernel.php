<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Actions\SyncMatchesAction;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $minutes = (int) env('MATCH_SYNC_FREQUENCY', 5);

        if ($minutes <= 0) {
            return;
        }

        // Use a cron expression for arbitrary minute intervals
        $cron = "*/{$minutes} * * * *";

        $schedule->call(function () {
            app(SyncMatchesAction::class)->execute();
        })->cron($cron)->withoutOverlapping();
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
