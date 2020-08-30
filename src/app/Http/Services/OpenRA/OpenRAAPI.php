<?php

namespace App\Http\Services\OpenRA;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenRAAPI
{
    private $_apiUrl = "https://master.openra.net/games.php?protocol=2&type=json";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('OpenRAAPI.getOnlineCount', 450, function ()
        {
            try 
            {
                $response = Http::get($this->_apiUrl);
                return $this->getPlayerCountFromResponse($response->json());
            }
            catch(Exception $exception)
            {
                Log::error($exception);
                return [];
            }
        });
    }

    private function getPlayerCountFromResponse($response)
    {
        $result = [];

        $games = [
            "ra", // openra ra
            "cnc", // openra td
        ];
        
        foreach($response as $server)
        {
            $serverListing = new OpenRAServerListing($server);

            if (in_array($serverListing->mod(), $games))
            {
                if (isset($result[$serverListing->mod()]))
                {
                    $result[$serverListing->mod()] += $serverListing->totalPlayers();
                }
                else
                {
                    $result[$serverListing->mod()] = $serverListing->totalPlayers();
                }
            }
        }

        // Make sure names don't clash
        $newResult = [];
        foreach($result as $k => $v)
        {
            $newResult["openra_".$k] = $v;
        }
        return $newResult;
    }
}
