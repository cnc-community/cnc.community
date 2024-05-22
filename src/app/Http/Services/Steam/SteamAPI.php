<?php

namespace App\Http\Services\Steam;

use App\Constants;
use App\Http\Services\SteamWorkShopItem;
use Illuminate\Support\Facades\Http;
use App\Http\Services\Steam\AbstractSteamAPI;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SteamAPI extends AbstractSteamAPI
{
    public const WORKSHOP_ITEMS_URL = "IPublishedFileService/QueryFiles/v1/";
    public const PLAYER_COUNT_URL = "ISteamUserStats/GetNumberOfCurrentPlayers/v1/";
    public const PLAYER_PROFILE_URL = "ISteamUser/GetPlayerSummaries/v1/";

    private $_apiUrl = "https://api.steampowered.com/";
    private $_apiKey;

    public function __construct()
    {
        $this->_apiKey = Constants::getSteamAPIKey();
    }

    private function buildResponse($response)
    {
        $workShopItems = [];
        if (!isset($response["publishedfiledetails"]))
        {
            return [];
        }

        foreach ($response["publishedfiledetails"] as $k => $v)
        {
            $workShopItems[] = new SteamWorkShopItem($v);
        }
        return $workShopItems;
    }

    public function getSteamProfileData($appId, $steamIds)
    {
        try
        {
            $response = Http::get(
                $this->_apiUrl . SteamAPI::PLAYER_PROFILE_URL .
                    '?appid=' . $appId .
                    '&steamids=' . $steamIds .
                    '&key=' . $this->_apiKey
            );

            $players = $response->json()["response"]["players"]["player"];
            if ($players)
            {
                return $players;
            }
        }
        catch (Exception $exception)
        {
            Log::error($exception);
            return -1;
        }
        // return Cache::remember('getSteamProfileData'.$appId, 86400, function () use($appId, $steamIds)
        // {
        // });
    }

    public function getSteamPlayerCount($appId)
    {
        return Cache::remember('getSteamPlayerCount' . $appId, 450, function () use ($appId)
        {
            try
            {
                $response = Http::get(
                    $this->_apiUrl . SteamAPI::PLAYER_COUNT_URL .
                        '?appid=' . $appId .
                        '&key=' . $this->_apiKey
                );

                $playerCount = $response->json()["response"]["player_count"];
                if ($playerCount)
                {
                    return $playerCount;
                }
            }
            catch (Exception $exception)
            {
                Log::error($exception);
                return -1;
            }
        });
    }

    public function getWorkshopItemsByAppId($appId)
    {
        return Cache::remember('getWorkshopItemsByAppId' . $appId, 86400, function () use ($appId) // 1 day cache
        {
            $response = Http::get(
                $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL .
                    '?appid=' . $appId .
                    '&key=' . $this->_apiKey .
                    '&return_tags=true&return_metadata=true&numperpage=6' .
                    '&required_flags=file_url,title,time_created,tags,favorited,views'
            );

            if (isset($response->json()["response"]))
            {
                return $this->buildResponse($response->json()["response"]);
            }
            return [];
        });
    }

    public function getTopWorkShopItemsByTagNames($cacheKey, $appId, $tagNames, $limit)
    {
        $tagQuery = "";
        foreach ($tagNames as $k => $tag)
        {
            $tagQuery .= "&requiredtags[" . $k . "]=" . $tag;
        }

        return Cache::remember(
            'getTopWorkShopItemsByTagNames' . $cacheKey . $appId . $tagQuery . $limit,
            43200,
            function () use ($appId, $tagQuery, $limit) // 1/2 day cache
            {
                $response = Http::get(
                    $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL .
                        '?appid=' . $appId .
                        '&key=' . $this->_apiKey .
                        $tagQuery .
                        '&match_all_tags=false' .
                        '&numperpage=' . $limit .
                        '&return_details=true' .
                        '&query_type=' . SteamAPI::RankedByTotalUniqueSubscriptions() .
                        '&strip_description_bbcode=true'
                );

                if (isset($response->json()["response"]))
                {
                    return $this->buildResponse($response->json()["response"]);
                }
                return [];
            }
        );
    }

    public function getTopWorkShopItemsByTagName($cacheKey, $appId, $tagName, $limit)
    {
        return Cache::remember('getTopWorkShopItemsByTagName' . $cacheKey . $appId . $tagName . $limit, 43200, function () use ($appId, $tagName, $limit) // 1/2 day cache
        {
            $response = Http::get(
                $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL .
                    '?appid=' . $appId .
                    '&key=' . $this->_apiKey .
                    '&requiredtags[0]=' . $tagName .
                    '&match_all_tags=true' .
                    '&numperpage=' . $limit .
                    '&return_details=true' .
                    '&query_type=' . SteamAPI::RankedByTotalUniqueSubscriptions() .
                    '&strip_description_bbcode=true'
            );

            if (isset($response->json()["response"]))
            {
                return $this->buildResponse($response->json()["response"]);
            }
            return [];
        });
    }

    public function getTopWorkShopItems($appId, $limit)
    {
        return Cache::remember('getTopWorkShopItems' . $appId . $limit, 43200, function () use ($appId, $limit) // 1/2 day cache
        {
            try
            {
                $response = Http::get(
                    $this->_apiUrl . SteamAPI::WORKSHOP_ITEMS_URL .
                        '?appid=' . $appId .
                        '&key=' . $this->_apiKey .
                        '&numperpage=' . $limit .
                        '&return_details=true' .
                        '&query_type=' . SteamAPI::RankedByTotalUniqueSubscriptions() .
                        '&strip_description_bbcode=true'
                );

                if (isset($response->json()["response"]))
                {
                    return $this->buildResponse($response->json()["response"]);
                }
                return [];
            }
            catch (Exception $exception)
            {
                Log::error($exception);
                return [];
            }
        });
    }

    private static function RankedByTotalUniqueSubscriptions()
    {
        return 9;
    }
}
