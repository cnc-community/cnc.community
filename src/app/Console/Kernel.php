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
        '\App\Console\Commands\RunLeaderboardSync',
        '\App\Console\Commands\RunLeaderboardMatchTask'
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

        $schedule->call('App\Http\Controllers\StatsController@runTask')
            ->everyTenMinutes()
            ->runInBackground();

        $schedule->call('App\Http\Controllers\StatsController@runCacheTask')
            ->everyFiveMinutes()
            ->runInBackground();

        $schedule->call('App\Http\Controllers\LeaderboardController@runMatchesTask')
            ->hourly()
            ->runInBackground();

        $schedule->call('App\Http\Controllers\LeaderboardController@runRALeaderboardTasks')
            ->hourly()
            ->runInBackground();

        $schedule->call('App\Http\Controllers\LeaderboardController@runTDLeaderboardTasks')
            ->everyThirtyMinutes()
            ->runInBackground();

        $schedule->call('App\Http\Controllers\FeedController@runTask')->daily()->runInBackground();
        $schedule->call('App\Http\Controllers\FeedController@runTaskDaily')->daily()->runInBackground();

        $schedule->call('App\Http\Controllers\APIController@runTask')->weekly()->runInBackground();
        $schedule->call('App\Http\Controllers\LeaderboardController@runProfileDataTask')->daily()->runInBackground();
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
