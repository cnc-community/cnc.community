<?php

namespace App\Console\Commands;

use App\Http\Controllers\StatsController;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use Illuminate\Console\Command;

class RunGraphStatsCacheTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:graphstats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run cache task for graph data';

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
        $c = new StatsController();
        $c->runCacheTask();

        $this->info("Done");
    }
}
