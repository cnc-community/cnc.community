<?php

namespace App\Http\Services\RA3BattleNet;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RA3BattleNetAPI
{
    private $_apiUrl = "https://api.ra3battle.cn/api/server/status/basic";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('RA3BattleNetAPI.getOnlineCount', 450, function ()
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
        return $data["onlinePlayerCount"];
    }
}
