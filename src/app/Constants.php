<?php 

namespace App;

class Constants
{
    public static function remastersAppId(): int
    {
        return 1213210;
    }

    public static function getCacheSeconds()
    {
        return config('app.cache_period');
    }

    public static function getTwitchSecret()
    {
        return config('app.twitch_secret');
    }

    public static function getTwitchClient()
    {
        return config('app.twitch_client');
    }

    public static function getSteamAPIKey()
    {
        return config('app.steam_api_key');
    }

    public static function getTwitchGames()
    {
        return
        [
            "red-alert" => "235", // Command & Conquer: Red Alert
            "red-alert-cs" => "10393", // Command & Conquer: Red Alert - Counterstrike
            "red-alert-am" => "14999", // Command & Conquer: Red Alert - The Aftermath
            "command-and-conquer" => "4012", // Command & Conquer
            "tiberian-sun" => "1900", // Command & Conquer: Tiberian Sun
            "tiberian-sun-firestorm" => "20015", // Command & Conquer: Tiberian Sun Firestorm
            "red-alert-2" => "16580", // Command & Conquer: Red Alert 2
            "red-alert-2-yuris-revenge" => "5090", // Command & Conquer: Yuri's Revenge
            "renegade" => "3813", // Command & Conquer: Renegade
            "red-alert-3" => "18881", // Command & Conquer: Red Alert 3
            "red-alert-3-kanes-wrath" => "18733", // Command & Conquer 3: Kane's Wrath
            "tiberium-wars" => "16106", // Command & Conquer 3: Tiberium Wars
            "generals" => "10070", // Command & Conquer: Generals
            "zero-hour" => "16487", // Command & Conquer: Zero hour
        ];
    }
}