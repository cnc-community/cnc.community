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

    public function getWorkshopItemsByAppId($appId)
    {
        return $this->steamAPI->getWorkshopItemsByAppId($appId);
    }

    public function getTopWorkShopItems($appId, $limit)
    {
        return $this->steamAPI->getTopWorkShopItems($appId, $limit);
    }

    public function getTopWorkShopItemsByTagNames($appId, $tags, $limit)
    {
        return $this->steamAPI->getTopWorkShopItemsByTagNames($appId, $tags, $limit);
    }

    public function getTopWorkShopItemsByTagName($appId, $tagName, $limit)
    {
        return $this->steamAPI->getTopWorkShopItemsByTagName($appId, $tagName, $limit);
    }

    public static function RedAlertMod() { return "RedAlertMod"; }
    public static function TiberianDawnMod() { return "TiberianDawnMod"; }
    public static function RedAlertMap() { return "RA"; }
    public static function TiberianDawnMap() { return "TD"; }
}