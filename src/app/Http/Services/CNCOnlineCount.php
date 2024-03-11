<?php

namespace App\Http\Services;

use App\Constants;
use App\GameStat;
use App\Http\Services\CnCNet\CnCNetAPI;
use App\Http\Services\CnCNet\CnCNetSoleAPI;
use App\Http\Services\CnCOnline\CnCOnlineAPI;
use App\Http\Services\OpenRA\OpenRAAPI;
use App\Http\Services\RenegadeX\RenegadeXAPI;
use App\Http\Services\W3DHub\W3DHubAPI;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CNCOnlineCount
{
    private $cncnetAPI;
    private $cnconlineAPI;
    private $w3dhubAPI;
    private $openRAAPI;
    private $renegadexAPI;
    private $steamHelper;
    private $cncnetSoleAPI;

    public function __construct()
    {
        $this->cncnetAPI = new CnCNetAPI();
        $this->cnconlineAPI = new CnCOnlineAPI();
        $this->w3dhubAPI = new W3DHubAPI();
        $this->openRAAPI = new OpenRAAPI();
        $this->renegadexAPI = new RenegadeXAPI();
        $this->steamHelper = new SteamHelper();
        $this->cncnetSoleAPI = new CnCNetSoleAPI();
    }

    public function runCountTasks()
    {
        $w3dhubCounts = $this->w3dhubAPI->getOnlineCount();
        $cncnetCounts = $this->cncnetAPI->getOnlineCount();
        $cnconlineCounts = $this->cnconlineAPI->getOnlineCount();
        $openraCounts = $this->openRAAPI->getOnlineCount();
        $renegadexCounts = $this->renegadexAPI->getOnlineCount();
        $cncnetSoleCounts = $this->cncnetSoleAPI->getOnlineCount();

        // Leaving this out for now until we get proper online numbers
        $remasterOnlineCount = ["cncremastered" => $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId())];

        $combined = array_merge(
            $cncnetCounts,
            $cnconlineCounts,
            $w3dhubCounts,
            $openraCounts,
            $remasterOnlineCount,
            $renegadexCounts,
            $cncnetSoleCounts
        );

        $combined["total"] = $this->total($combined);
        $this->groupAndSaveIntoGameTypes($combined);
    }

    public function getGameCounts()
    {
        return GameStat::getStatsByType(GameStat::TYPE_GAME);
    }

    public function getModCounts()
    {
        return GameStat::getStatsByType(GameStat::TYPE_MOD);
    }

    public function getStandaloneCounts()
    {
        return GameStat::getStatsByType(GameStat::TYPE_STANDALONE);
    }

    public function getTotal()
    {
        return Cache::remember('CNCOnlineCount.getTotalPlayersOnline', 450, function ()
        {
            return GameStat::getTotalPlayersOnline();
        });
    }

    private function groupAndSaveIntoGameTypes($results)
    {
        $newResults = [
            "games" => [],
            "mods" => [],
            "communityGames" => []
        ];

        $modsFilter = [
            "cncnet5_mo" => 1,
            "cncnet5_rr" => 2,
            "cncnet5_cncr" => 3,
        ];

        $communityGamesFilter = [
            "apb" => 1,
            "ia" => 2,
            "cncnet5_dta" => 3,
            "renegadex" => 5,
            "openra_ra" => 6,
            "openra_cnc" => 7,
        ];

        // Abbreviation + order
        $gamesFilter = [
            "cncremastered" => 0,
            "cncnet5_td" => 1,
            "cncnet5_ra" => 2,
            "sole" => 3,
            "cncnet5_ts" => 4,
            "cncnet5_yr" => 5,
            "ren" => 6,
            "generals" => 7,
            "generalszh" => 8,
            "cnc3" => 9,
            "cnc3kw" => 10,
            "ra3" => 11,
        ];

        $steamGamesFilter = [
            "cncnet5_td",
            "cncnet5_ra",
            "cncnet5_ts",
            "cncnet5_yr",
            "ren",
            "generals",
            "generalszh",
            "cnc3",
            "cnc3kw",
            "ra3",
        ];

        // Collect results into correct groups
        foreach ($results as $game => $count)
        {
            if (array_key_exists($game, $gamesFilter))
            {
                $newResults["games"][$game] = $count;
                $order = $gamesFilter[$game];
                $steamInGameCount = 0;

                // Hack - Fetch individual steam players online
                if (in_array($game, $steamGamesFilter))
                {
                    $steamId = Constants::getSteamIDByAbbrev($game);
                    if ($steamId)
                    {
                        $steamInGameCount = $this->steamHelper->getSteamPlayerCount($steamId);
                    }
                }

                GameStat::createOrUpdateStat(
                    $game,
                    $count,
                    GameStat::TYPE_GAME,
                    $order,
                    $steamInGameCount
                );
            }

            if (array_key_exists($game, $modsFilter))
            {
                $newResults["mods"][$game] = $count;
                $order = $modsFilter[$game];
                GameStat::createOrUpdateStat($game, $count, GameStat::TYPE_MOD, $order);
            }

            if (array_key_exists($game, $communityGamesFilter))
            {
                $newResults["communityGames"][$game] = $count;
                $order = $communityGamesFilter[$game];
                GameStat::createOrUpdateStat($game, $count, GameStat::TYPE_STANDALONE, $order);
            }
        }
    }

    private function total($results)
    {
        $total = 0;
        foreach ($results as $k => $v)
        {
            if (is_int($v))
            {
                $total += $v;
            }
        }
        return $total;
    }

    public function createGraph($graphData, $includeGameAbbreviations = [])
    {
        // Format for Chart.js
        $dataSets = [];

        ini_set('memory_limit', '1024M');

        Log::info("createGraph ** Memory limit set");

        $gameStatsIds = collect($graphData)->pluck('game_stats_id')->unique();
        Log::info("createGraph ** gameStatsIds collected");

        $gameStats = GameStat::whereIn('id', $gameStatsIds)->get()->keyBy('id');

        Log::info("createGraph ** gameStats query complete");

        foreach ($graphData as $gameStatGraph)
        {
            if (isset($gameStats[$gameStatGraph->game_stats_id]))
            {
                $gameStat = $gameStats[$gameStatGraph->game_stats_id];
                $dataSets[$gameStat->getAbbreviation()][] = [
                    $gameStatGraph->created_at,
                    $gameStatGraph->players_online
                ];
            }
        }

        Log::info("createGraph ** graphData loop complete");

        $chartJsFormat = [];
        foreach ($dataSets as $abbrev => $dataSet)
        {
            if (!in_array($abbrev, $includeGameAbbreviations))
            {
                continue;
            }
            $chartJsFormat[$abbrev]["data"] = $this->createChartJsFormat($dataSet, 60);
            $chartJsFormat[$abbrev]["label"] = $this->getNameByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["backgroundColor"] = $this->getColourByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["borderColor"] = $this->getBorderColorByAbbrev($abbrev);
        }

        Log::info("Returning Chart JS Format");

        return $chartJsFormat;
    }

    public function createGraphForInGameStats($graphData, $includeGameAbbreviations = [])
    {
        // Format for Chart.js
        $dataSets = [];

        ini_set('memory_limit', '1024M');

        Log::info("createGraph ** Memory limit set");

        $gameStatsIds = collect($graphData)->pluck('game_stats_id')->unique();
        Log::info("createGraph ** gameStatsIds collected");

        $gameStats = GameStat::whereIn('id', $gameStatsIds)->get()->keyBy('id');

        Log::info("createGraph ** gameStats query complete");

        foreach ($graphData as $gameStatGraph)
        {
            if (isset($gameStats[$gameStatGraph->game_stats_id]))
            {
                $gameStat = $gameStats[$gameStatGraph->game_stats_id];
                $dataSets[$gameStat->getAbbreviation()][] = [
                    $gameStatGraph->created_at,
                    $gameStatGraph->steam_players_online
                ];
            }
        }

        Log::info("createGraph ** graphData loop complete");

        $chartJsFormat = [];
        foreach ($dataSets as $abbrev => $dataSet)
        {
            if (!in_array($abbrev, $includeGameAbbreviations))
            {
                continue;
            }
            $chartJsFormat[$abbrev]["data"] = $this->createChartJsFormat($dataSet, 60);
            $chartJsFormat[$abbrev]["label"] = $this->getNameByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["backgroundColor"] = $this->getColourByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["borderColor"] = $this->getBorderColorByAbbrev($abbrev);
        }

        Log::info("Returning Chart JS Format");

        return $chartJsFormat;
    }

    private function getNameByAbbrev($gameAbbrev)
    {
        return Constants::getGameFromOnlineAbbreviation($gameAbbrev)["name"];
    }

    private function getColourByAbbrev($gameAbbrev)
    {
        return Constants::getGameFromOnlineAbbreviation($gameAbbrev)["graph_color"];
    }

    private function getBorderColorByAbbrev($gameAbbrev)
    {
        return Constants::getGameFromOnlineAbbreviation($gameAbbrev)["graph_border_color"];
    }

    /**
     * 
     * @param mixed $arr 
     * @param int $timeGapMinutes - Value in which to have a gap between each dataset 
     * @return array 
     */
    private function createChartJsFormat($arr, $timeGapMinutes = 60)
    {
        $newResult = [];
        $prevCarbon = null;

        foreach ($arr as $obj)
        {
            $currentCarbonTime = $obj[0]; // Assuming 't' is the key for Carbon object
            $currentValue = $obj[1];

            if ($prevCarbon === null)
            {
                $prevCarbon = $currentCarbonTime;
            }
            else
            {
                // Calculate the time difference in minutes
                $timeDiffMinutes = $currentCarbonTime->diffInMinutes($prevCarbon);

                // If the time difference is at least 1 hr
                if ($timeDiffMinutes >= $timeGapMinutes)
                {
                    $newResult[] = [
                        "t" => $currentCarbonTime,
                        "y" => $currentValue,
                    ];

                    // Update the previous carbon timestamp
                    $prevCarbon = $currentCarbonTime;
                }
            }

            // Update the previous carbon timestamp if it's null
            if ($prevCarbon === null)
            {
                $prevCarbon = $currentCarbonTime;
            }
        }

        return $newResult;
    }
}
