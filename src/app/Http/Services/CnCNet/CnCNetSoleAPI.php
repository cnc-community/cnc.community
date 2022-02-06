<?php

namespace App\Http\Services\CnCNet;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CnCNetSoleAPI
{
    private $_apiUrl = "https://api.cncnet.org/solesurvivor";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('CnCNetSoleAPI.getOnlineCount', 450, function ()
        {
            try
            {
                $response = Http::get(
                    $this->_apiUrl
                );
                return $this->getPlayerCountFromResponse($response->json());
            }
            catch (Exception $exception)
            {
                Log::error($exception);
                return [];
            }
        });
    }

    private function getPlayerCountFromResponse($data)
    {
        $totalPlayers = 0;
        foreach ($data as $server)
        {
            $count = intval($server["total_players"]);
            $totalPlayers += $count;
        }

        return ["sole" => $totalPlayers];
    }
}
