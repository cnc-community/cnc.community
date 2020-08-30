<?php

namespace App\Http\Services;

use App\Constants;
use App\Http\Services\CnCNet\CnCNetAPI;
use App\Http\Services\CnCOnline\CnCOnlineAPI;
use App\Http\Services\W3DHub\W3DHubAPI;

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
        $this->steamHelper = new SteamHelper();
    }

    public function getGameCounts()
    {
        $w3dhubCounts = $this->w3dhubAPI->getOnlineCount();
        $cncnetCounts = $this->cncnetAPI->getOnlineCount();
        $cnconlineCounts = $this->cnconlineAPI->getOnlineCount();
        $remasterOnlineCount = ["cncremastered" => $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId())];

        $combined = array_merge($cncnetCounts, $cnconlineCounts, $remasterOnlineCount, $w3dhubCounts);
        $combined["total"] = $this->total($combined);
        return $combined;
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