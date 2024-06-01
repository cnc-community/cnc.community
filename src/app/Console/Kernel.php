<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::info("Cron run");

        $schedule->call('App\Console\ClearExpiredCommand@handle')->hourly();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\StatsController();
            $task->runTask();
        })->everyTenMinutes();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\LadderController();
            $task->syncRemasters();
        })->everyFourHours();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\LadderController();
            $task->syncNineBitArmies();
        })->everyFourHours();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\StatsController();
            $task->runCacheTask();
        })->everyFiveMinutes();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\APIController();
            $task->runTask();
        })->weekly();

        $schedule->call(function ()
        {
            $task = new \App\Http\Controllers\FeedController();
            $task->runTaskDaily();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
