<?php

namespace App\Http\Services\RenegadeX;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RenegadeXAPI
{
    private $_apiUrl = "https://serverlist.ren-x.com/metadata";

    public function __construct()
    {
    }

    public function getOnlineCount()
    {
        return Cache::remember('RenegadeXAPI.getOnlineCount', 450, function ()
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
        return ["renegadex" => $data["player_count"] ?? 0];
    }
}
