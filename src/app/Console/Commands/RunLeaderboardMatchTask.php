<?php

namespace App\Console\Commands;

use App\Http\Services\Petroglyph\PetroglyphAPIService;
use Illuminate\Console\Command;

class RunLeaderboardMatchTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync match data';

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
        $petroglyphAPIService->runMatchesTask();

        return 0;
    }
}
