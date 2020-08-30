<?php

namespace App\Http\Services\W3DHub;

use App\Constants;
use App\Http\Services\W3DHub\GSHServerListing;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class W3DHubAPI
{
    private $_apiUrl = "https://gsh.w3dhub.com/listings/getAll/v2?statusLevel=2";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('W3DHubAPI.getOnlineCount', 450, function ()
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
            "ren",
        ];
        
        foreach($response as $server)
        {
            $serverListing = new GSHServerListing($server);

            if (in_array($serverListing->game(), $games))
            {
                if (isset($result[$serverListing->game()]))
                {
                    $result[$serverListing->game()] += $serverListing->status()->playerCount();
                }
                else
                {
                    $result[$serverListing->game()] = $serverListing->status()->playerCount();
                }
            }
        }
        return $result;
    }
}
