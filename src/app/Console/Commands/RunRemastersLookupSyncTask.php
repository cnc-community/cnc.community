<?php

namespace App\Console\Commands;

use App\Http\Controllers\LadderController;
use App\Http\Services\Petroglyph\NineBitArmiesAPI;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use Illuminate\Console\Command;

class RunRemastersLookupSyncTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remasters:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Remasters Lookup Sync Task';

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
        $petroglyphAPIService = new LadderController();
        $petroglyphAPIService->syncRemasters();
        return 0;
    }
}
