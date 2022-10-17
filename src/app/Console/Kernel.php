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
        $schedule->call('App\Console\ClearExpiredCommand@handle')->everyMinute();

        $schedule->call('App\Http\Controllers\StatsController@runTask')
            ->everyTenMinutes()
            ->runInBackground();

        // $schedule->call('App\Http\Controllers\LeaderboardController@runMatchesTask')
        //     ->everyFifteenMinutes()
        //     ->runInBackground();

        // $schedule->call('App\Http\Controllers\LeaderboardController@runRALeaderboardTasks')
        //     ->cron('*/8 * * * *')
        //     ->runInBackground();

        // $schedule->call('App\Http\Controllers\LeaderboardController@runTDLeaderboardTasks')
        //     ->cron('*/8 * * * *')
        //     ->runInBackground();

        $schedule->call('App\Http\Controllers\FeedController@runTask')->hourly()->runInBackground();
        $schedule->call('App\Http\Controllers\FeedController@runTaskDaily')->daily()->runInBackground();
        // $schedule->call('App\Http\Controllers\APIController@runTask')->weekly()->runInBackground();
        // $schedule->call('App\Http\Controllers\LeaderboardController@runProfileDataTask')->daily()->runInBackground();
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
