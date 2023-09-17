<?php

namespace App\Console\Commands;

use App\Http\Services\Petroglyph\PetroglyphAPIService;
use Illuminate\Console\Command;

class RunLeaderboardSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Leaderboard Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $petroglyphAPIService = new PetroglyphAPIService();
        $petroglyphAPIService->runRALeaderboardTasks($canSleep = false);
        $petroglyphAPIService->runTDLeaderboardTasks($canSleep = false);

        return 0;
    }
}
