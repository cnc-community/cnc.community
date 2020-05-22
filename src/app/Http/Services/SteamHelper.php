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
        $response = $this->steamAPI->getWorkshopItemsByAppId($appId)["publishedfiledetails"];
        
        $workShopItems = [];
        foreach($response as $k => $v) 
        {
            $workShopItems[] = new SteamWorkShopItem($v);
        }
        return $workShopItems;
    }
}