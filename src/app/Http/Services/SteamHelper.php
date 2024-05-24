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

    /**
     * 
     * @param mixed $appId 
     * @param mixed $steamIdArr 
     * @return mixed 
     */
    public function getSteamProfiles($appId, $steamIdArr)
    {
        /**
         * Response
         *  "steamid" => "76561199101543383"
         *  "communityvisibilitystate" => 3
         *  "profilestate" => 1
         *  "personaname" => "Preußens Gloria"
         *  "profileurl" => "https://steamcommunity.com/profiles/76561199101543383/"
         *  "avatar" => "https://avatars.steamstatic.com/b2da4cd67c58bc0a991f9b747ffa2264b4fc6a6f.jpg"
         *  "avatarmedium" => "https://avatars.steamstatic.com/b2da4cd67c58bc0a991f9b747ffa2264b4fc6a6f_medium.jpg"
         *  "avatarfull" => "https://avatars.steamstatic.com/b2da4cd67c58bc0a991f9b747ffa2264b4fc6a6f_full.jpg"
         *  "avatarhash" => "b2da4cd67c58bc0a991f9b747ffa2264b4fc6a6f"
         *  "personastate" => 0
         *  "realname" => ""
         *  "primaryclanid" => "103582791429521408"
         *  "timecreated" => 1603718875
         *  "personastateflags" => 0
         *  "loccountrycode" => "DE"
         */
        $steamIds = implode(', ', $steamIdArr);

        $chunkSize = 100;

        // Split the Steam IDs into chunks
        $steamIdChunks = array_chunk($steamIdArr, $chunkSize);

        // Array to store all players' data
        $allPlayers = [];

        foreach ($steamIdChunks as $chunk)
        {
            $steamIds = implode(', ', $chunk); // Create a comma-separated string from the chunk
            $players = $this->steamAPI->getSteamProfileData($appId, $steamIds); // Call the API for each chunk
            $allPlayers = array_merge($allPlayers, $players); // Merge the results into the main array
        }

        return $allPlayers;
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

    public static function RedAlertMod()
    {
        return "RedAlertMod";
    }
    public static function TiberianDawnMod()
    {
        return "TiberianDawnMod";
    }
    public static function RedAlertMap()
    {
        return "RA";
    }
    public static function TiberianDawnMap()
    {
        return "TD";
    }
}
