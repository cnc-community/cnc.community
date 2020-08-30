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

    public static function getRemasterGameBySlug($slug)
    {
        $remasterGames =
        [
            "red-alert" => [ 
                "long_name" => "Red Alert Remastered",
                "short_name" => "Red Alert" 
            ], 
            "tiberian-dawn" => [ 
                "long_name" => "Tiberian Dawn Remastered",
                "short_name" => "Tiberian Dawn"
            ], 
            "default"   => [ 
                "long_name" => "",
                "short_name" => ""
            ], 
        ];

        if (array_key_exists($slug, $remasterGames))
        {
            return $remasterGames[$slug];
        }
        return $remasterGames["default"];
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

    public static function getGameFromOnlineAbbreviation($abbreviation)
    {
        switch($abbreviation)
        {
            case "cncnet5_td":
                return [
                    "url" => "tiberian-dawn",
                    "logo" => ViewHelper::getGameLogoPathByName("tiberian-dawn"),
                    "external_link" => false,
                    "name" => "Tiberian Dawn"
                ];
            
            case "cncnet5_ra":
                return [
                    "url" => "red-alert",
                    "logo" => ViewHelper::getGameLogoPathByName("red-alert"),
                    "external_link" => false,
                    "name" => "Red Alert"
                ];

            case "cncnet5_ts":
                return [
                    "url" => "tiberian-sun",
                    "logo" => ViewHelper::getGameLogoPathByName("tiberian-sun"),
                    "external_link" => false,
                    "name" => "Tiberian Sun"
                ];

            case "cncnet5_yr":
                return [
                    "url" => "red-alert-2",
                    "logo" => ViewHelper::getGameLogoPathByName("yuris-revenge"),
                    "external_link" => false,
                    "name" => "Yuri's Revenge"
                ];

            case "cncnet5_dta":
                return [
                    "url" => "https://cncnet.org/dawn-of-the-tiberium-age",
                    "logo" => ViewHelper::getGameLogoPathByName("dawn-of-the-tiberium-age"),
                    "external_link" => true,
                    "name" => "Dawn of the Tiberium Age"
                ];
            
            case "cncnet5_mo":
                return [
                    "url" => "https://cncnet.org/mental-omega",
                    "logo" => ViewHelper::getGameLogoPathByName("mental-omega"),
                    "external_link" => true,
                    "name" => "Mental Omega"
                ];
            
            case "cncnet5_ti":
                return [
                    "url" => "https://cncnet.org/twisted-insurrection",
                    "logo" => ViewHelper::getGameLogoPathByName("twisted-insurrection"),
                    "external_link" => true,
                    "name" => "Twisted Insurrection"
                ];

            case "cncnet5_rr":
                return [
                    "url" => "https://cncnet.org/red-resurrection",
                    "logo" => ViewHelper::getGameLogoPathByName("yr-red-resurrection"),
                    "external_link" => true,
                    "name" => "YR Red-Resurrection"
                ];
            
            case "cncnet5_cncr":
                return [
                    "url" => "https://www.moddb.com/mods/cncreloaded",
                    "logo" => ViewHelper::getGameLogoPathByName("cncreloaded"),
                    "external_link" => true,
                    "name" => "C&C: Reloaded"
                ];

            case "cnc3":
                return [
                    "url" => "command-and-conquer-3",
                    "logo" => ViewHelper::getGameLogoPathByName("command-and-conquer-3"),
                    "external_link" => false,
                    "name" => "C&C3: Tiberium Wars"
                ];
                      
            case "ren":
                return [
                    "url" => "renegade",
                    "logo" => ViewHelper::getGameLogoPathByName("renegade"),
                    "external_link" => false,
                    "name" => "Renegade"
                ];
                        
            case "cnc3kw":
                return [
                    "url" => "command-and-conquer-3/how-to-play",
                    "logo" => ViewHelper::getGameLogoPathByName("command-and-conquer-3-kanes-wrath"),
                    "external_link" => false,
                    "name" => "C&C3: Kane's Wrath"
                ];
                     
            case "generals":
                return [
                    "url" => "generals",
                    "logo" => ViewHelper::getGameLogoPathByName("generals"),
                    "external_link" => false,
                    "name" => "Generals"
                ];
            
            case "generalszh":
                return [
                    "url" => "generals/how-to-play",
                    "logo" => ViewHelper::getGameLogoPathByName("generals-zero-hour"),
                    "external_link" => false,
                    "name" => "Generals: Zero Hour"
                ];
               
            case "ra3":
                return [
                    "url" => "red-alert-3",
                    "logo" => ViewHelper::getGameLogoPathByName("red-alert-3"),
                    "external_link" => false,
                    "name" => "Red Alert 3"
                ];
                     
            case "cncremastered":
                return [
                    "url" => "command-and-conquer-remastered",
                    "logo" => ViewHelper::getGameLogoPathByName("cnc-remastered"),
                    "external_link" => false,
                    "name" => "C&C Remastered Collection"
                ];

            case "apb":
                return [
                    "url" => "https://w3dhub.com/#/games-apb",
                    "logo" => ViewHelper::getGameLogoPathByName("a-path-beyond"),
                    "external_link" => true,
                    "name" => "Red Alert: A Path Beyond"
                ];

            case "ia":
                return [
                    "url" => "https://w3dhub.com/forum/topic/416844-interim-apex/",
                    "logo" => ViewHelper::getGameLogoPathByName("interim-apex"),
                    "external_link" => true,
                    "name" => "Interim Apex"
                ];
                
            case "openra_cnc":
                return [
                    "url" => "https://www.openra.net/",
                    "logo" => ViewHelper::getGameLogoPathByName("openra-td"),
                    "external_link" => true,
                    "name" => "OpenRA: Tiberian Dawn"
                ];

            case "openra_ra":
                return [
                    "url" => "https://www.openra.net/",
                    "logo" => ViewHelper::getGameLogoPathByName("openra"),
                    "external_link" => true,
                    "name" => "OpenRA: Red Alert"
                ];

            case "renegadex":
                return [
                    "url" => "https://renegade-x.com/",
                    "logo" => ViewHelper::getGameLogoPathByName("renegade-x"),
                    "external_link" => true,
                    "name" => "Renegade X"
                ];
        }

        return [
            "url" => "",
            "logo" => "",
            "external_link" => false,
            "name" => ""
        ];
    }
}