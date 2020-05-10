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

    public static function getTwitchGames()
    {
        return
        [
                "235", // Command & Conquer: Red Alert
                "10393", // Command & Conquer: Red Alert - Counterstrike
                "14999", // Command & Conquer: Red Alert - The Aftermath
                "4012", // Command & Conquer
                "1900", // Command & Conquer: Tiberian Sun
                "20015", // Command & Conquer: Tiberian Sun Firestorm
                "16580", // Command & Conquer: Red Alert 2
                "5090", // Command & Conquer: Yuri's Revenge
                "3813", // Command & Conquer: Renegade
                "18881", // Command & Conquer: Red Alert 3
                "18733", // Command & Conquer 3: Kane's Wrath
                "16106", // Command & Conquer 3: Tiberium Wars
                "10070", // Command & Conquer: Generals
                "16487", // Command & Conquer: Zero hour
                "16487", // Command & Conquer: Zero hour
        ];
    }
}