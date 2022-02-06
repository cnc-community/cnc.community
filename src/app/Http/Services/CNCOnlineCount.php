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
            "cncnet5_ti" => 4,
            "renegadex" => 5,
            "openra_ra" => 6,
            "openra_cnc" => 7,
        ];

        // Abbreviation + order
        $gamesFilter = [
            "cncremastered" => 0,
            "cncnet5_td" => 1,
            "cncnet5_ra" => 2,
            "sole" > 3,
            "cncnet5_ts" => 4,
            "cncnet5_yr" => 5,
            "ren" => 6,
            "generals" => 7,
            "generalszh" => 8,
            "cnc3" => 9,
            "cnc3kw" => 10,
            "ra3" => 11,
        ];

        // Collect results into correct groups
        foreach ($results as $game => $count)
        {
            if (array_key_exists($game, $gamesFilter))
            {
                $newResults["games"][$game] = $count;
                $order = $gamesFilter[$game];
                GameStat::createOrUpdateStat($game, $count, GameStat::TYPE_GAME, $order);
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

    public function createGraph($graphData)
    {
        // Format for Chart.js
        $dataSets = [];
        foreach ($graphData as $gameStatGraph)
        {
            $gameStat = GameStat::where("id", $gameStatGraph->game_stats_id)->first();
            $dataSets[$gameStat->getAbbreviation()][] = [$gameStatGraph->created_at, $gameStatGraph->players_online];
        }

        $chartJsFormat = [];
        foreach ($dataSets as $abbrev => $dataSet)
        {
            $chartJsFormat[$abbrev]["data"] = $this->createChartJsFormat($dataSet);
            $chartJsFormat[$abbrev]["label"] = $this->getNameByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["backgroundColor"] = $this->getColourByAbbrev($abbrev);
            $chartJsFormat[$abbrev]["borderColor"] = $this->getBorderColorByAbbrev($abbrev);
        }

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

    private function createChartJsFormat($arr)
    {
        $newResult = [];
        foreach ($arr as $obj)
        {
            $newResult[] =
                [
                    "t" => $obj[0],
                    "y" => $obj[1],
                ];
        }
        return $newResult;
    }
}
