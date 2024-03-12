<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Vite;

class LeaderboardHelper
{
    public static function mapPreviewByInternalName($internalName): string
    {
        return Vite::asset("resources/assets/images/leaderboard/maps/" . $internalName . ".png");
    }

    public static function getFactionById($id): string
    {
        switch ($id)
        {
            case -1:
                return "invalid";
            case 0:
                return "gdi";
            case 1:
                return "nod";
            case 2:
                return "spain";
            case 3:
                return "greece";
            case 4:
                return "ussr";
            case 5:
                return "england";
            case 6:
                return "ukraine";
            case 7:
                return "germany";
            case 8:
                return "france";
            case 9:
                return "turkey";
            case 42:
                return "random";
        }
        return "random";
    }

    public static function getBadgeByRank($rank)
    {
        // So in our case, General would be in top 16,
        // Colonel would be in top 50, Major would be in top 100, 
        // Captain would be in top 200, Lieutenant in top 400, 
        // Sergeant in top 800 and Private otherwise.

        $path = Vite::asset("resources/assets/images/leaderboard/");

        if ($rank > 0 && $rank <= 16)
        {
            return [
                "image" => $path . "general.png",
                "rank" => "General"
            ];
        }
        else if ($rank > 16 && $rank <= 100)
        {
            return [
                "image" => $path . "colonel.png",
                "rank" => "Colonel"
            ];
        }
        else if ($rank > 100 && $rank <= 200)
        {
            return [
                "image" => $path . "major.png",
                "rank" => "Major"
            ];
        }
        else if ($rank > 200 && $rank <= 400)
        {
            return [
                "image" => $path . "captain.png",
                "rank" => "Captain"
            ];
        }
        else if ($rank > 400 && $rank <= 800)
        {
            return [
                "image" => $path . "lieutenant.png",
                "rank" => "Lieutenant"
            ];
        }

        return [
            "image" => $path . "sergeant.png",
            "rank" => "Sergeant"
        ];
    }
}
