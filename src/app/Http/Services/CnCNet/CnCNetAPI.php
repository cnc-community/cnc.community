<?php

namespace App\Http\Services\CnCNet;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CnCNetAPI
{
    private $_apiUrl = "https://api.cncnet.org/status";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('CnCNetAPI.getOnlineCount', 450, function ()
        {
            try 
            {
                $response = Http::get(
                    $this->_apiUrl
                );
        
                return $this->getPlayerCountFromResponse($response->json());
            }
            catch(Exception $exception)
            {
                Log::error($exception);
                return [];
            }
        });
    }

    private function getPlayerCountFromResponse($data)
    {
        $games = [
            "cncnet5_td",
            "cncnet5_ra",
            "cncnet5_ts",
            "cncnet5_yr",
            "cncnet5_mo",
            "cncnet5_dta",
            "cncnet5_rr",
            "cncnet5_ti",
            "cncnet5_cncr"
        ];
        
        $result = [];

        foreach($data as $gameKey => $gameCount)
        {
            if (in_array($gameKey, $games))
            {
                $result[$gameKey] = $gameCount;
            }
        }
        
        return $result;
    }
}
