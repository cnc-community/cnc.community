<?php

namespace App\Http\Controllers;

use App\Constants;
use App\GameStat;
use App\GameStatGraph;
use App\Http\Services\CNCOnlineCount;
use App\StatsCache;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class StatsController extends Controller
{
    private $cncOnlineCount;

    public function __construct()
    {
        $this->cncOnlineCount = new CNCOnlineCount();

        View::share('totalOnline', $this->cncOnlineCount->getTotal());
        // $this->runCacheTask();
    }

    // Cron task only
    public function runCacheTask()
    {
        try
        {
            Log::info("runCacheTask ** Started");
            $data = GameStatGraph::getLast3Months();
            Log::info("runCacheTask ** Data found");

            $filteredGameAbbreviations = Constants::getGameAbbreviations();
            Log::info("runCacheTask ** Abbreviations found");

            $onlineCount = new CNCOnlineCount();
            Log::info("runCacheTask ** Created service");

            $graphData = $onlineCount->createGraph(
                $data,
                $filteredGameAbbreviations
            );

            StatsCache::saveCache(
                GameStatGraph::GAME_STAT_GRAPH_CACHE_3_MONTHS,
                $graphData,
                20
            ); // 20 minutes

            $graphDataSteamInGame = $onlineCount->createGraphForInGameStats(
                $data,
                $filteredGameAbbreviations
            );

            StatsCache::saveCache(
                GameStatGraph::GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_3_MONTHS,
                $graphDataSteamInGame,
                20
            ); // 20 minutes

            Log::info("runCacheTask Completed");
        }
        catch (Exception $ex)
        {
            Log::info("Error running cache task: " . $ex->getMessage());
        }
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
        $graphData = StatsCache::getCache(GameStatGraph::GAME_STAT_GRAPH_CACHE_3_MONTHS) ?? [];

        if ($request->steamInGame)
        {
            $graphData = StatsCache::getCache(GameStatGraph::GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_3_MONTHS) ?? [];
        }

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

        $steamInGameOnly = "steamInGame=true&filteredGames=";
        foreach ($games as $game)
        {
            $gameByAbbreviation = Constants::getGameFromOnlineAbbreviation($game->abbrev);
            $steamInGameOnly .= urlencode($gameByAbbreviation["name"] . ',');
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
                "standaloneUrlOnly" => $standaloneUrlOnly,
                "steamInGameOnly" => $steamInGameOnly,
            ]
        );
    }
}
