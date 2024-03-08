<?php

namespace App;

class Constants
{
    public static function remastersAppId(): int
    {
        return 1213210;
    }

    public static function getSteamIDByAbbrev($abbrev): ?int
    {
        switch ($abbrev)
        {
            case "cncnet5_td":
                return 2229830;

            case "cncnet5_ra":
                return 2229840;

            case "cncnet5_ts":
                return 2229880;

            case "cncnet5_yr":
                return 2229850;

            case "ren":
                return 2229890;

            case "generals":
                return 2229870;

            case "generalszh":
                return 2732960;

            case "cnc3":
                return 24790;

            case "cnc3kw":
                return 24810;

            case "ra3":
                return 17480;
        }
        return null;
    }

    // RA3 - 17480
    // Uprising - 24800

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

    public static function getTUCSteamPageUrl()
    {
        return "https://store.steampowered.com/bundle/39394/";
    }

    public static function getTUCEAPageUrl()
    {
        return "https://www.ea.com/games/command-and-conquer/command-and-conquer-the-ultimate-collection/buy/pc";
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
                "remasters" => "517837", // C&C Remastered Collection,
                "sole-survivor" => "8884",
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
                "sole-survivor" => "Sole Survivor",
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
        $cdnUrl = "//cdn.jsdelivr.net/gh/cnc-community/files@" . $version . "/";
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

    public static function getGameAbbreviations()
    {
        return [
            "cncnet5_td",
            "cncnet5_ra",
            "cncnet5_ts",
            "sole",
            "cncnet5_yr",
            "cncnet5_dta",
            "cncnet5_mo",
            "cncnet5_rr",
            "cncnet5_cncr",
            "cnc3",
            "ren",
            "cnc3kw",
            "generals",
            "generalszh",
            "ra3",
            "cncremastered",
            "apb",
            "ia",
            "openra_cnc",
            "openra_ra",
            "renegadex",
        ];
    }

    public static function getGameFromOnlineAbbreviation($abbreviation)
    {
        switch ($abbreviation)
        {
            case "cncnet5_td":
                return [
                    "url" => "tiberian-dawn",
                    "logo" => ViewHelper::getGameLogoPathByName("tiberian-dawn"),
                    "external_link" => false,
                    "name" => "Tiberian Dawn",
                    "graph_color" => "rgba(255, 215, 0, 0.3)",
                    "graph_border_color" => "rgba(255, 215, 0, 1)"
                ];

            case "cncnet5_ra":
                return [
                    "url" => "red-alert",
                    "logo" => ViewHelper::getGameLogoPathByName("red-alert"),
                    "external_link" => false,
                    "name" => "Red Alert",
                    "graph_color" => "rgba(255, 0, 0, 0.3)",
                    "graph_border_color" => "rgba(255, 0, 0, 1)"
                ];

            case "cncnet5_ts":
                return [
                    "url" => "tiberian-sun",
                    "logo" => ViewHelper::getGameLogoPathByName("tiberian-sun"),
                    "external_link" => false,
                    "name" => "Tiberian Sun",
                    "graph_color" => "rgba(212, 127, 0, 0.3)",
                    "graph_border_color" => "rgba(212, 127, 0, 1)"
                ];

            case "sole":
                return [
                    "url" => "https://cnc-comm.com/sole-survivor",
                    "logo" => ViewHelper::getGameLogoPathByName("sole-survivor"),
                    "external_link" => true,
                    "name" => "Sole Survivor",
                    "graph_color" => "rgba(255,255,255,0.5)",
                    "graph_border_color" => "rgba(255,255,255,0.5)"
                ];

            case "cncnet5_yr":
                return [
                    "url" => "red-alert-2",
                    "logo" => ViewHelper::getGameLogoPathByName("yuris-revenge"),
                    "external_link" => false,
                    "name" => "Yuri's Revenge",
                    "graph_color" => "rgba(255, 19, 128, 0.3)",
                    "graph_border_color" => "rgba(255, 19, 128, 1)"
                ];

            case "cncnet5_dta":
                return [
                    "url" => "https://cncnet.org/dawn-of-the-tiberium-age",
                    "logo" => ViewHelper::getGameLogoPathByName("dawn-of-the-tiberium-age"),
                    "external_link" => true,
                    "name" => "Dawn of the Tiberium Age",
                    "graph_color" => "rgba(0, 184, 255, 0.2)",
                    "graph_border_color" => "rgba(0, 184, 255, 0.8)"
                ];

            case "cncnet5_mo":
                return [
                    "url" => "https://cncnet.org/mental-omega",
                    "logo" => ViewHelper::getGameLogoPathByName("mental-omega"),
                    "external_link" => true,
                    "name" => "Mental Omega",
                    "graph_color" => "rgba(202, 21, 251, 0.2)",
                    "graph_border_color" => "rgba(202, 21, 251, 0.8)"
                ];

            case "cncnet5_rr":
                return [
                    "url" => "https://cncnet.org/red-resurrection",
                    "logo" => ViewHelper::getGameLogoPathByName("yr-red-resurrection"),
                    "external_link" => true,
                    "name" => "YR Red-Resurrection",
                    "graph_color" => "rgba(230, 109, 154, 0.2)",
                    "graph_border_color" => "rgba(230, 109, 154, 0.8)"
                ];

            case "cncnet5_cncr":
                return [
                    "url" => "https://cncnet.org/cnc-reloaded",
                    "logo" => ViewHelper::getGameLogoPathByName("cncreloaded"),
                    "external_link" => true,
                    "name" => "C&C: Reloaded",
                    "graph_color" => "rgba(42, 212, 0, 0.2)",
                    "graph_border_color" => "rgba(42, 212, 0, 0.8)"
                ];

            case "cnc3":
                return [
                    "url" => "command-and-conquer-3",
                    "logo" => ViewHelper::getGameLogoPathByName("command-and-conquer-3"),
                    "external_link" => false,
                    "name" => "C&C3: Tiberium Wars",
                    "graph_color" => "rgba(31, 255, 48, 0.3)",
                    "graph_border_color" => "rgba(31, 255, 48, 1)",
                ];

            case "ren":
                return [
                    "url" => "renegade",
                    "logo" => ViewHelper::getGameLogoPathByName("renegade"),
                    "external_link" => false,
                    "name" => "Renegade",
                    "graph_color" => "rgba(185, 114, 255, 0.3)",
                    "graph_border_color" => "rgba(185, 114, 255, 1)"
                ];

            case "cnc3kw":
                return [
                    "url" => "command-and-conquer-3/how-to-play",
                    "logo" => ViewHelper::getGameLogoPathByName("command-and-conquer-3-kanes-wrath"),
                    "external_link" => false,
                    "name" => "C&C3: Kane's Wrath",
                    "graph_color" => "rgba(0, 55, 255, 0.3)",
                    "graph_border_color" => "rgba(0, 55, 255, 1)",
                ];

            case "generals":
                return [
                    "url" => "generals",
                    "logo" => ViewHelper::getGameLogoPathByName("generals"),
                    "external_link" => false,
                    "name" => "Generals",
                    "graph_color" => "rgba(30, 144, 23, 0.3)",
                    "graph_border_color" => "rgba(30, 144, 23, 1)"
                ];

            case "generalszh":
                return [
                    "url" => "generals/how-to-play",
                    "logo" => ViewHelper::getGameLogoPathByName("generals-zero-hour"),
                    "external_link" => false,
                    "name" => "Generals: Zero Hour",
                    "graph_color" => "rgba(253, 198, 75, 0.3)",
                    "graph_border_color" => "rgba(253, 198, 75, 1)"
                ];

            case "ra3":
                return [
                    "url" => "red-alert-3",
                    "logo" => ViewHelper::getGameLogoPathByName("red-alert-3"),
                    "external_link" => false,
                    "name" => "Red Alert 3",
                    "graph_color" => "rgba(253, 75, 75, 0.3)",
                    "graph_border_color" => "rgba(253, 75, 75, 1)",
                ];

            case "cncremastered":
                return [
                    "url" => "command-and-conquer-remastered",
                    "logo" => ViewHelper::getGameLogoPathByName("cnc-remastered"),
                    "external_link" => false,
                    "name" => "C&C Remastered Collection",
                    "graph_color" => "rgba(0, 255, 208, 0.3)",
                    "graph_border_color" => "rgba(0, 255, 208, 1)"
                ];

            case "apb":
                return [
                    "url" => "https://w3dhub.com/#/games-apb",
                    "logo" => ViewHelper::getGameLogoPathByName("a-path-beyond"),
                    "external_link" => true,
                    "name" => "Red Alert: A Path Beyond",
                    "graph_color" => "rgba(253, 3, 1, 0.2)",
                    "graph_border_color" => "rgba(253, 3, 1, 0.8)",
                ];

            case "ia":
                return [
                    "url" => "https://w3dhub.com/forum/topic/416844-interim-apex/",
                    "logo" => ViewHelper::getGameLogoPathByName("interim-apex"),
                    "external_link" => true,
                    "name" => "Interim Apex",
                    "graph_color" => "rgba(0, 218, 186, 0.2)",
                    "graph_border_color" => "rgba(0, 218, 186, 0.8)",
                ];

            case "openra_cnc":
                return [
                    "url" => "https://www.openra.net/",
                    "logo" => ViewHelper::getGameLogoPathByName("openra-td"),
                    "external_link" => true,
                    "name" => "OpenRA: Tiberian Dawn",
                    "graph_color" => "rgba(121, 121, 121,0.2)",
                    "graph_border_color" => "rgba(121, 121, 121, 0.8)",
                ];

            case "openra_ra":
                return [
                    "url" => "https://www.openra.net/",
                    "logo" => ViewHelper::getGameLogoPathByName("openra"),
                    "external_link" => true,
                    "name" => "OpenRA: Red Alert",
                    "graph_color" => "rgba(255, 211, 0, 0.2)",
                    "graph_border_color" => "rgba(255, 211, 0, 0.8)"
                ];

            case "renegadex":
                return [
                    "url" => "https://ren-x.com/",
                    "logo" => ViewHelper::getGameLogoPathByName("renegade-x"),
                    "external_link" => true,
                    "name" => "Renegade X",
                    "graph_color" => "rgba(136, 232, 249, 0.2)",
                    "graph_border_color" => "rgba(136, 232, 249, 1)",
                ];
        }

        return [
            "url" => "",
            "logo" => "",
            "external_link" => false,
            "name" => "",
            "graph_color" => "rgb(18 3 47)"
        ];
    }
}
