<?php

namespace App\Http\Services\CnCNet;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CnCNetAPI
{
    private $_apiUrl = "https://api.cncnet.org/status";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('CnCNetAPI.getOnlineCount', 600, function ()
        {
            try 
            {
                $response = Http::get(
                    $this->_apiUrl
                );
        
                return $this->buildResponse($response->json());
            }
            catch(Exception $ex)
            {
                return [];
            }
        });
    }

    private function buildResponse($data)
    {
        $games = [
            "cncnet5_td",
            "cncnet5_ra",
            "cncnet5_ts",
            "cncnet5_yr"
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
