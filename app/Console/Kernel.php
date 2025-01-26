<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule){
        $schedule->command('mail:send')->everyMinute();
        $schedule->command('sitemap:generate')->cron('0 4 * * *');
    }

    protected function commands(){
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
