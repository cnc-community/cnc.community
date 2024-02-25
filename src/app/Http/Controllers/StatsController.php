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

        $graphData = $this->cncOnlineCount->createGraph(
            GameStatGraph::getLast5Years(),
            $filteredGameAbbreviations
        );

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
