<?php

namespace App\Console;

use App\Console\Commands\UnblockUser;
use App\Jobs\NotificationTrigger;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BirthdayWish;

class Kernel extends ConsoleKernel
{
    protected $commands = [
    ];
    /**
     * Define the application's command schedule..
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $schedule->command(BirthdayWish::class)->timezone('Asia/Calcutta')->dailyAt('19:15')->withoutOverlapping();
        // $schedule->command(UnblockUser::class)->daily();
        // $schedule->command('queue:list')
        // ->everyMinute()
        // ->withoutOverlapping()
        // ->sendOutputTo(storage_path() . '/logs/queue-jobs.log');
        $schedule->command('user:session-reminder-one-day-before')->daily();// every day
        $schedule->command('user:session-reminder-thirty-min-before')->everyMinute();// every min
        $schedule->command('user:buy-new-program')->daily();// every day
        $schedule->command('user:payment-due')->daily();// every day


        

        // or use ->dailyAt('10:00') or ->everyMinute(), etc.
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
