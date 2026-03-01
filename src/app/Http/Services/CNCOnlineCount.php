<?php

namespace App\Http\Services;

use App\Constants;
use App\GameStat;
use App\Http\Services\CnCNet\CnCNetAPI;
use App\Http\Services\CnCNet\CnCNetSoleAPI;
use App\Http\Services\CnCOnline\CnCOnlineAPI;
use App\Http\Services\GeneralsOnline\GeneralsOnlineAPI;
use App\Http\Services\OpenRA\OpenRAAPI;
use App\Http\Services\RA3BattleNet\RA3BattleNetAPI;
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
    private $ra3BattleNetAPI;
    private $generalsOnlineAPI;

    public function __construct()
    {
        $this->cncnetAPI = new CnCNetAPI();
        $this->cnconlineAPI = new CnCOnlineAPI();
        $this->w3dhubAPI = new W3DHubAPI();
        $this->openRAAPI = new OpenRAAPI();
        $this->renegadexAPI = new RenegadeXAPI();
        $this->steamHelper = new SteamHelper();
        $this->cncnetSoleAPI = new CnCNetSoleAPI();
        $this->ra3BattleNetAPI = new RA3BattleNetAPI();
        $this->generalsOnlineAPI = new GeneralsOnlineAPI();
    }

    public function runCountTasks()
    {
        $w3dhubCounts = $this->w3dhubAPI->getOnlineCount();
        $cncnetCounts = $this->cncnetAPI->getOnlineCount();
        $cnconlineCounts = $this->cnconlineAPI->getOnlineCount();
        $openraCounts = $this->openRAAPI->getOnlineCount();
        $renegadexCounts = $this->renegadexAPI->getOnlineCount();
        $cncnetSoleCounts = $this->cncnetSoleAPI->getOnlineCount();
        $ra3battleNetCounts = $this->ra3BattleNetAPI->getOnlineCount();
        $generalsOnlineCounts = $this->generalsOnlineAPI->getOnlineCount();

        // Leaving this out for now until we get proper online numbers
        $remasterOnlineCount = ["cncremastered" => $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId())];

        $combined = array_merge(
            $cncnetCounts,
            $cnconlineCounts,
            $w3dhubCounts,
            $openraCounts,
            $remasterOnlineCount,
            $renegadexCounts,
            $cncnetSoleCounts,
            ["ra3Battlenet" => $ra3battleNetCounts],
            ["generalsOnline" => $generalsOnlineCounts]
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
            "ar" => 8
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
            "generalsOnline" => 8,
            "generalszh" => 9,
            "cnc3" => 10,
            "cnc3kw" => 11,
            "ra3" => 12,
            "ra3Battlenet" => 13,
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
                $generalsOnlineCount = 0;

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
                    $steamInGameCount,
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

    /**
     * Build both online and steam in-game graph datasets in a single pass.
     * Expects pre-aggregated hourly data from GameStatGraph::getLast3MonthsHourly().
     *
     * @return array ['online' => [...], 'steam' => [...]]
     */
    public function createGraphs($graphData, $includeGameAbbreviations = [])
    {
        $gameStatsIds = collect($graphData)->pluck('game_stats_id')->unique();
        $gameStats = GameStat::whereIn('id', $gameStatsIds)->get()->keyBy('id');

        $onlineDataSets = [];
        $steamDataSets = [];

        foreach ($graphData as $row)
        {
            if (!isset($gameStats[$row->game_stats_id]))
            {
                continue;
            }

            $abbrev = $gameStats[$row->game_stats_id]->getAbbreviation();

            if (!in_array($abbrev, $includeGameAbbreviations))
            {
                continue;
            }

            $point = ["t" => $row->hour_bucket, "y" => (int) $row->players_online];
            $onlineDataSets[$abbrev][] = $point;

            $steamPoint = ["t" => $row->hour_bucket, "y" => (int) $row->steam_players_online];
            $steamDataSets[$abbrev][] = $steamPoint;
        }

        $onlineChart = $this->formatDataSetsForChartJs($onlineDataSets);
        $steamChart = $this->formatDataSetsForChartJs($steamDataSets);

        Log::info("createGraphs ** Completed");

        return ['online' => $onlineChart, 'steam' => $steamChart];
    }

    private function formatDataSetsForChartJs($dataSets)
    {
        $chartJsFormat = [];
        foreach ($dataSets as $abbrev => $dataSet)
        {
            $chartJsFormat[$abbrev] = [
                "data" => $dataSet,
                "label" => $this->getNameByAbbrev($abbrev),
                "backgroundColor" => $this->getColourByAbbrev($abbrev),
                "borderColor" => $this->getBorderColorByAbbrev($abbrev),
            ];
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

}
