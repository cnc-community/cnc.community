<?php

namespace App\Http\Services\CnCOnline;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CnCOnlineAPI
{
    private $_apiUrl = "https://info.server.cnc-online.net/";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('CnCOnlineAPI.getOnlineCount', 450, function ()
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
            "cnc3",
            "cnc3kw",
            "generals",
            "generalszh",
            "ra3"
        ];
        
        $result = [];
        foreach($data as $gameKey => $gameArr)
        {
            if (in_array($gameKey, $games))
            {
                $result[$gameKey] = count($gameArr["users"]);
            }
        }
        
        return $result;
    }
}
