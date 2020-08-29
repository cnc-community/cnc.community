<?php

namespace App\Http\Services;

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

        return array_merge($cncnetCounts, $cnconlineCounts);
    }
}