<?php

namespace App\Http\Services\Steam;

use App\Constants;
use App\Http\Services\SteamWorkShopItem;
use Illuminate\Support\Facades\Http;
use App\Http\Services\Twitch\AbstractTwitchAPI;
use Illuminate\Support\Facades\Cache;

class SteamAPI extends AbstractSteamAPI
{
    public const WORKSHOP_ITEMS_URL = "IPublishedFileService/QueryFiles/v1/";

    private $_apiUrl = "https://api.steampowered.com/";
    private $_apiKey;

    public function __construct()
    {
        $this->_apiKey = Constants::getSteamAPIKey();
    }

    public function getWorkshopItemsByAppId($appId)
    {
        return Cache::remember('getWorkshopItemsByAppId'.$appId, 86400, function () use($appId) // 1 day cache
        {
            // Http::withOptions([
            //     'debug' => true
            //     ]
            $response = Http::get(
                    $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL . 
                    '?appid='. $appId . 
                    '&key='. $this->_apiKey .
                    '&return_tags=true&return_metadata=true&numperpage=20'.
                    '&required_flags=file_url,title,time_created,tags,favorited,views'
                );

            return $response->json()["response"];
        });
    }
}
