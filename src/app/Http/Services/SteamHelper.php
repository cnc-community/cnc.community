<?php 

namespace App\Http\Services;

use App\Http\Services\Steam\SteamAPI;

class SteamHelper
{
    private $steamAPI;
    
    public function __construct()
    {
        $this->steamAPI = new SteamAPI();
    }

    public function getSteamProfiles($appId, $steamIds)
    {
        return $this->steamAPI->getSteamProfileData($appId, $steamIds);
    }

    public function getSteamPlayerCount($appId)
    {
        return $this->steamAPI->getSteamPlayerCount($appId);
    }

    public function getWorkshopItemsByAppId($appId)
    {
        return $this->steamAPI->getWorkshopItemsByAppId($appId);
    }

    public function getTopWorkShopItems($appId, $limit)
    {
        return $this->steamAPI->getTopWorkShopItems($appId, $limit);
    }

    public function getTopWorkShopItemsByTagNames($cacheKey, $appId, $tags, $limit)
    {
        return $this->steamAPI->getTopWorkShopItemsByTagNames($cacheKey, $appId, $tags, $limit);
    }

    public function getTopWorkShopItemsByTagName($cacheKey, $appId, $tagName, $limit)
    {
        return $this->steamAPI->getTopWorkShopItemsByTagName($cacheKey, $appId, $tagName, $limit);
    }

    public static function RedAlertMod() { return "RedAlertMod"; }
    public static function TiberianDawnMod() { return "TiberianDawnMod"; }
    public static function RedAlertMap() { return "RA"; }
    public static function TiberianDawnMap() { return "TD"; }
}