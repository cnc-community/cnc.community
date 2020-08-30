<?php

namespace App\Http\Services;

use App\Constants;
use App\GameStat;
use App\Http\Services\CnCNet\CnCNetAPI;
use App\Http\Services\CnCOnline\CnCOnlineAPI;
use App\Http\Services\OpenRA\OpenRAAPI;
use App\Http\Services\W3DHub\W3DHubAPI;
use Illuminate\Support\Facades\Cache;

class CNCOnlineCount
{
    private $cncnetAPI;
    private $cnconlineAPI;
    private $w3dhubAPI;
    private $steamHelper;

    public function __construct()
    {
        $this->cncnetAPI = new CnCNetAPI();
        $this->cnconlineAPI = new CnCOnlineAPI();
        $this->w3dhubAPI = new W3DHubAPI();
        $this->openRAAPI = new OpenRAAPI();
        $this->steamHelper = new SteamHelper();
    }

    public function runCountTasks()
    {
        $w3dhubCounts = $this->w3dhubAPI->getOnlineCount();
        $cncnetCounts = $this->cncnetAPI->getOnlineCount();
        $cnconlineCounts = $this->cnconlineAPI->getOnlineCount();
        $openraCounts = $this->openRAAPI->getOnlineCount();

        // Leaving this out for now until we get proper online numbers
        // $remasterOnlineCount = ["cncremastered" => $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId())];

        $combined = array_merge($cncnetCounts, $cnconlineCounts, $w3dhubCounts, $openraCounts);
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
        return Cache::remember('CNCOnlineCount.getOnlingetTotaleCount', 450, function ()
        {
            return GameStat::getTotalPlayersOnline();
        });
    }

    private function groupAndSaveIntoGameTypes($results)
    {
        $newResults = [
            "games" => [],
            "mods" => [],
            "standalone" => []
        ];

        $modsFilter = [
            "apb",
            "ia",
            "cncnet5_dta",
            "cncnet5_ti",
            "cncnet5_mo",
            "cncnet5_rr",
        ];

        $standaloneFilter = [
            "renegadex",
            "openra_ra",
            "openra_cnc"
        ];

        $gamesFilter = [
            // "cncremastered",
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
        foreach($results as $game => $count)
        {
            if (in_array($game, $gamesFilter))
            {
                $newResults["games"][$game] = $count;
            }
            if (in_array($game, $modsFilter))
            {
                $newResults["mods"][$game] = $count;
            }
            if (in_array($game, $standaloneFilter))
            {
                $newResults["standalone"][$game] = $count;
            }
        }

        // Order based on array filter keys
        $orderedResults = [];
        $orderedResults["games"] = $this->sortByArrayFilter($newResults["games"], $gamesFilter);
        $orderedResults["mods"] = $this->sortByArrayFilter($newResults["mods"], $modsFilter);
        $orderedResults["standalone"] = $this->sortByArrayFilter($newResults["standalone"], $standaloneFilter);

        // Save order we want in db
        foreach($orderedResults as $type => $result)
        {
            $order = 0;

            foreach($result as $gameAbbrev => $count)
            {
                $order++;
                GameStat::createOrUpdateStat($gameAbbrev, $count, $type, $order);
            }
        }
    }

    private function sortByArrayFilter($resultsArr, $filterArr)
    {
        // Otherwise we get keys as values
        if (count($resultsArr) > 0)
        {
            return array_merge(array_flip($filterArr), $resultsArr);
        }
        return [];
    }

    private function total($results)
    {
        $total = 0;
        foreach($results as $k => $v)
        {
            if (is_int($v))
            {
                $total += $v;
            }
        }
        return $total;
    }
}