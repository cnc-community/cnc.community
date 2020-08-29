<?php

namespace App\Http\Services;

use App\Constants;
use App\Http\Services\CnCNet\CnCNetAPI;
use App\Http\Services\CnCOnline\CnCOnlineAPI;

class CNCOnlineCount
{
    private $cncnetAPI;
    private $cnconlineAPI;
    private $steamHelper;

    public function __construct()
    {
        $this->cncnetAPI = new CnCNetAPI();
        $this->cnconlineAPI = new CnCOnlineAPI();
        $this->steamHelper = new SteamHelper();
    }

    public function getGameCounts()
    {
        $cncnetCounts = $this->cncnetAPI->getOnlineCount();
        $cnconlineCounts = $this->cnconlineAPI->getOnlineCount();
        $remasterOnlineCount = ["cncremastered" => $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId())];

        $combined = array_merge($cncnetCounts, $cnconlineCounts, $remasterOnlineCount);
        $combined["total"] = $this->total($combined);
        return $combined;
    }

    private function total($results)
    {
        $total = 0;
        foreach($results as $k => $v)
        {
            $total += $v;
        }
        return $total;
    }
}