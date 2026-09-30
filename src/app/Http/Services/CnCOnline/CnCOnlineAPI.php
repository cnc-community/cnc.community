<?php

namespace App\Http\Services\CnCOnline;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CnCOnlineAPI
{
    private $_apiUrl = "https://cnc-online.net/api/serverinfo/";

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

                $data = $response->json();

                if ($response->successful() && is_array($data))
                {
                    return $this->getPlayerCountFromResponse($data);
                }

                Log::error('CnCOnlineAPI failed: ' . $response->status() . ' ' . $response->header('Content-Type'));
                return [];
            }
            catch (Exception $exception)
            {
                Log::error('CnCOnlineAPI exception: ' . $exception->getMessage());
                return [];
            }
        });
    }

    private function getPlayerCountFromResponse($data)
    {
        $games = [
            "cnc3",
            "cnc3kw",
            "ra3",
        ];

        $result = [];
        foreach ($data as $gameKey => $gameArr)
        {
            if (in_array($gameKey, $games) && isset($gameArr["users"]) && is_array($gameArr["users"]))
            {
                $result[$gameKey] = count($gameArr["users"]);
            }
        }

        return $result;
    }
}
