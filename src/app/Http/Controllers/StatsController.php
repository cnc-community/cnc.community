<?php

namespace App\Http\Controllers;

use App\GameStat;
use App\GameStatGraph;
use App\Http\Services\CNCOnlineCount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class StatsController extends Controller
{
    private $cncOnlineCount;

    public function __construct()
    {
        $this->cncOnlineCount = new CNCOnlineCount();
        
        View::share('totalOnline', $this->cncOnlineCount->getTotal());
    }

    // Cron task only
    public function runTask()
    {
        return $this->cncOnlineCount->runCountTasks();
    }

    public function showStats()
    {
        $games = Cache::remember("StatsController.showStats.games", 450, function () 
        {
            return $this->cncOnlineCount->getGameCounts();
        });

        $mods = Cache::remember("StatsController.showStats.mods", 450, function () 
        {
            return $this->cncOnlineCount->getModCounts();
        });
        
        $standalone = Cache::remember("StatsController.showStats.standalone", 450, function () 
        {
            return $this->cncOnlineCount->getStandaloneCounts();
        });

        $graphData = $this->cncOnlineCount->createGraph(GameStatGraph::getLast24Hours());

        return view('pages.stats', 
        [
            "games" => $games,
            "mods" => $mods,
            "standalone" => $standalone,
            "graphData" => $graphData
        ]);
    }
}
