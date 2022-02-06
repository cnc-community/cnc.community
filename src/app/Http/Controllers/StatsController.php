<?php

namespace App\Http\Controllers;

use App\Constants;
use App\GameStat;
use App\GameStatGraph;
use App\Http\Services\CNCOnlineCount;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function showStats(Request $request)
    {
        $games = $this->cncOnlineCount->getGameCounts();
        $mods = $this->cncOnlineCount->getModCounts();
        $standalone =  $this->cncOnlineCount->getStandaloneCounts();
        $filteredGameAbbreviations  = Constants::getGameAbbreviations();

        if ($request->filteredGames)
        {
            $filteredGameAbbreviations = explode(",", $request->filteredGames);
        }

        $graphData = $this->cncOnlineCount->createGraph(
            GameStatGraph::getLast24Hours(),
            $filteredGameAbbreviations
        );

        return view(
            'pages.stats',
            [
                "games" => $games,
                "mods" => $mods,
                "standalone" => $standalone,
                "graphData" => $graphData
            ]
        );
    }
}
