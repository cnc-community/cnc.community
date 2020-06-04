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
            "tiberian-dawn" => "4012", // Command & Conquer
            "tiberian-sun" => "1900", // Command & Conquer: Tiberian Sun
            "tiberian-sun-firestorm" => "20015", // Command & Conquer: Tiberian Sun Firestorm
            "red-alert-2" => "16580", // Command & Conquer: Red Alert 2
            "red-alert-2-yuris-revenge" => "5090", // Command & Conquer: Yuri's Revenge
            "renegade" => "3813", // Command & Conquer: Renegade
            "red-alert-3" => "18881", // Command & Conquer: Red Alert 3
            "command-and-conquer-3-kanes-wrath" => "18733", // Command & Conquer 3: Kane's Wrath
            "tiberium-wars" => "16106", // Command & Conquer 3: Tiberium Wars
            "generals" => "10070", // Command & Conquer: Generals
            "zero-hour" => "16487", // Command & Conquer: Zero hour,
            "remasters" => "517837" // C&C Remastered Collection
        ];
    }

    // Hacky but for getting live, quickest solution
    public static function getTwitchGameBySlug($slug)
    {
        $twitchGames =
        [
            "red-alert" => "Red Alert", // Command & Conquer: Red Alert
            "tiberian-dawn" => "Tiberian Dawn", // Command & Conquer
            "tiberian-sun" => "Tiberian Sun", // Command & Conquer: Tiberian Sun
            "red-alert-2" => "Red Alert 2", // Command & Conquer: Red Alert 2
            "red-alert-2-yuris-revenge" => "Yuris' Revenge", // Command & Conquer: Red Alert 2
            "renegade" => "Renegade", // Command & Conquer: Renegade
            "red-alert-3" => "Red Alert 3", // Command & Conquer: Red Alert 3
            "command-and-conquer-3-kanes-wrath" => "C&C 3: Kanes Wrath", // Command & Conquer 3: Kane's Wrath
            "tiberium-wars" => "C&C 3: Tiberium Wars", // Command & Conquer 3: Tiberium Wars
            "generals" => "Generals", // Command & Conquer: Generals
            "zero-hour" => "Zero Hour", // Command & Conquer: Zero hour,
            "remasters" => "C&C Remastered Collection", // C&C Remastered Collection,
            "default" => ""
        ];

        if (array_key_exists($slug, $twitchGames))
        {
            return $twitchGames[$slug];
        }
        return $twitchGames["default"];
    }
    
    public static function getVideoWithPoster($slug)
    {
        $version = 1.4;
        $cdnUrl = "//cdn.jsdelivr.net/gh/cnc-community/files@". $version . "/";
        $posterSrc = "/assets/images/posters/";

        $videos = [
            "command-and-conquer-remastered" => 
            [ 
                "src" => $cdnUrl . "cnc-remastered.mp4",
                "poster" => $posterSrc . "cnc-remastered.jpg"
            ],      
            "red-alert" => [ 
                "src" => $cdnUrl . "red-alert-1.mp4",
                "poster" => $posterSrc . "red-alert-1.jpg"
            ],
            "tiberian-dawn" => [ 
                "src" => $cdnUrl . "tiberian-dawn.mp4",
                "poster" => $posterSrc . "tiberian-dawn.jpg"
            ],
            "tiberian-sun" => [ 
                "src" => $cdnUrl . "tiberian-sun.mp4",
                "poster" => $posterSrc . "tiberian-sun.jpg"
            ],
            "red-alert-2" => [ 
                "src" => $cdnUrl . "red-alert-2.mp4",
                "poster" => $posterSrc . "red-alert-2.jpg"
            ],
            "renegade" => [ 
                "src" => $cdnUrl . "renegade.mp4",
                "poster" => $posterSrc . "renegade.jpg"
            ],
            "generals" => [ 
                "src" => $cdnUrl . "generals.mp4",
                "poster" => $posterSrc . "generals.jpg"
            ],
            "command-and-conquer-3" => [ 
                "src" => $cdnUrl . "tiberium-wars.mp4",
                "poster" => $posterSrc . "tiberium-wars.jpg"
            ],
            "red-alert-3" => [ 
                "src" => $cdnUrl . "red-alert-3.mp4",
                "poster" => $posterSrc . "red-alert-3.jpg"
            ],
            "command-and-conquer-4" => [ 
                "src" => $cdnUrl . "tiberium-twighlight.mp4",
                "poster" => $posterSrc . "command-and-conquer-4.jpg"
            ],
            "default" => [
                "src" => "",
                "poster" => ""
            ]
        ];

        if (array_key_exists($slug, $videos))
        {
            return $videos[$slug];
        }
        return $videos["default"];
    }
}