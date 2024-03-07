<?php

namespace App\Http\Controllers;

use App\Constants;
use App\GameStat;
use App\GameStatGraph;
use App\Http\Services\CNCOnlineCount;
use App\StatsCache;
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

        $this->runTask();
    }

    // Cron task only
    public function runCacheTask()
    {
        $data = GameStatGraph::getLast5Years();
        $filteredGameAbbreviations  = Constants::getGameAbbreviations();
        $graphData = $this->cncOnlineCount->createGraph(
            $data,
            $filteredGameAbbreviations
        );

        StatsCache::saveCache(GameStatGraph::GAME_STAT_GRAPH_CACHE_5_YEARS, $graphData, 20); // 20 minutes
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
        $graphData = StatsCache::getCache(GameStatGraph::GAME_STAT_GRAPH_CACHE_5_YEARS) ?? [];

        $selectedLabels = explode(",", $request->filteredGames) ?? [];
        $officialGamesUrlOnly = "filteredGames=";
        foreach ($games as $game)
        {
            $gameByAbbreviation = Constants::getGameFromOnlineAbbreviation($game->abbrev);
            $officialGamesUrlOnly .= urlencode($gameByAbbreviation["name"] . ',');
        }

        $modGamesUrlOnly = "filteredGames=";
        foreach ($mods as $game)
        {
            $gameByAbbreviation = Constants::getGameFromOnlineAbbreviation($game->abbrev);
            $modGamesUrlOnly .= urlencode($gameByAbbreviation["name"] . ',');
        }

        $standaloneUrlOnly = "filteredGames=";
        foreach ($standalone as $game)
        {
            $gameByAbbreviation = Constants::getGameFromOnlineAbbreviation($game->abbrev);
            $standaloneUrlOnly .= urlencode($gameByAbbreviation["name"] . ',');
        }


        return view(
            'pages.stats',
            [
                "games" => $games,
                "mods" => $mods,
                "standalone" => $standalone,
                "graphData" => $graphData,
                "selectedLabels" => $selectedLabels,
                "officialGamesUrlOnly" => $officialGamesUrlOnly,
                "modGamesUrlOnly" => $modGamesUrlOnly,
                "standaloneUrlOnly" => $standaloneUrlOnly
            ]
        );
    }
}
