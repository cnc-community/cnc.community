<?php

namespace App\Console\Commands;

use App\Http\Services\Petroglyph\NineBitArmiesAPI;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use Illuminate\Console\Command;

class RunNineBitArmiesLookupSyncTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ninebitarmies:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run NineBitArmies Lookup Sync Task';

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
        $petroglyphAPIService = new NineBitArmiesAPI();
        $petroglyphAPIService->runSyncMatchNameLookup();
        return 0;
    }
}
