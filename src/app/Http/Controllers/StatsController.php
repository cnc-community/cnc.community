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

            $data = GameStatGraph::getLast3MonthsHourly();
            $filteredGameAbbreviations = Constants::getGameAbbreviations();
            $onlineCount = new CNCOnlineCount();

            $graphs = $onlineCount->createGraphs($data, $filteredGameAbbreviations);

            StatsCache::saveCache(
                GameStatGraph::GAME_STAT_GRAPH_CACHE_3_MONTHS,
                $graphs['online'],
                20
            );

            StatsCache::saveCache(
                GameStatGraph::GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_3_MONTHS,
                $graphs['steam'],
                20
            );

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
        $allGames = $this->cncOnlineCount->getGameCounts();

        // Separate out generalsOnline and ra3Battlenet from the main games list
        $games = $allGames->filter(function($game) {
            return !in_array($game->abbrev, ['generalsOnline', 'ra3Battlenet']);
        });

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

        // Build combined stats for Generals and RA3
        $generalsStats = $this->buildGeneralsStats($allGames);
        $ra3Stats = $this->buildRA3Stats($allGames);

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
                "generalsStats" => $generalsStats,
                "ra3Stats" => $ra3Stats,
            ]
        );
    }

    private function buildGeneralsStats($allGames)
    {
        $stats = [];

        // Get both generalszh and generalsOnline
        $generalszh = $allGames->firstWhere('abbrev', 'generalszh');
        $generalsOnline = $allGames->firstWhere('abbrev', 'generalsOnline');

        if ($generalszh) {
            $generalszhInfo = Constants::getGameFromOnlineAbbreviation('generalszh');
            $stats[] = [
                'count' => $generalszh->players_online,
                'service' => $generalszhInfo['online_service'],
                'serviceUrl' => $generalszhInfo['online_service_url'],
            ];
        }

        if ($generalsOnline) {
            $generalsOnlineInfo = Constants::getGameFromOnlineAbbreviation('generalsOnline');
            $stats[] = [
                'count' => $generalsOnline->players_online,
                'service' => $generalsOnlineInfo['online_service'],
                'serviceUrl' => $generalsOnlineInfo['online_service_url'],
            ];
        }

        return $stats;
    }

    private function buildRA3Stats($allGames)
    {
        $stats = [];

        // Get both ra3 and ra3Battlenet
        $ra3 = $allGames->firstWhere('abbrev', 'ra3');
        $ra3Battlenet = $allGames->firstWhere('abbrev', 'ra3Battlenet');

        if ($ra3) {
            $ra3Info = Constants::getGameFromOnlineAbbreviation('ra3');
            $stats[] = [
                'count' => $ra3->players_online,
                'service' => $ra3Info['online_service'],
                'serviceUrl' => $ra3Info['online_service_url'],
            ];
        }

        if ($ra3Battlenet) {
            $ra3BattlenetInfo = Constants::getGameFromOnlineAbbreviation('ra3Battlenet');
            $stats[] = [
                'count' => $ra3Battlenet->players_online,
                'service' => $ra3BattlenetInfo['online_service'],
                'serviceUrl' => $ra3BattlenetInfo['online_service_url'],
            ];
        }

        return $stats;
    }
}
