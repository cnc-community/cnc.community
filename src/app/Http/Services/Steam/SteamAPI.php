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

    private function buildResponse($response) 
    {
        $workShopItems = [];
        foreach($response["publishedfiledetails"] as $k => $v) 
        {
            $workShopItems[] = new SteamWorkShopItem($v);
        }
        return $workShopItems;
    }

    public function getWorkshopItemsByAppId($appId)
    {
        $response = Http::get(
                $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL . 
                '?appid='. $appId . 
                '&key='. $this->_apiKey .
                '&return_tags=true&return_metadata=true&numperpage=6'.
                '&required_flags=file_url,title,time_created,tags,favorited,views'
            );

        return $this->buildResponse($response->json()["response"]);
        return Cache::remember('getWorkshopItemsByAppId'.$appId, 86400, function () use($appId) // 1 day cache
        {
        });
    }

    public function getTopWorkShopItemsByTagName($appId, $tagName, $limit)
    {
        $response = Http::get(
                $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL . 
                '?appid='. $appId . 
                '&key='. $this->_apiKey .
                '&requiredtags[0]='. $tagName .
                '&match_all_tags=true' .
                '&numperpage='.$limit .
                '&return_details=true' .
                '&query_type='. SteamAPI::RankedByTotalUniqueSubscriptions() .
                '&strip_description_bbcode=true'
            );

        return $this->buildResponse($response->json()["response"]);
    }

    public function getTopWorkShopItems($appId, $limit)
    {
        $response = Http::get(
                $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL . 
                '?appid='. $appId . 
                '&key='. $this->_apiKey .
                '&numperpage='.$limit .
                '&return_details=true' .
                '&query_type='. SteamAPI::RankedByTotalUniqueSubscriptions() .
                '&strip_description_bbcode=true'
            );

        return $this->buildResponse($response->json()["response"]);
    }

    private static function RankedByTotalUniqueSubscriptions() { return 9; }
}
