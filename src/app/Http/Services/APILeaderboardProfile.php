<?php 

namespace App\Http\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Image;
use Illuminate\Support\Facades\Storage;

class APILeaderboardProfile
{
    public static function buildProfileWebViewUrl($gameSlug, $playerId)
    {
        $parts = parse_url(url()->full());
        $generatedUrl = "";
        if (isset($parts["query"]))
        {
            $generatedUrl = url("/api/leaderboard/". $gameSlug . "/player/". $playerId ."/webview?".$parts["query"]);
        }
        return $generatedUrl;
    }

    public static function buildProfile(Request $request)
    {
        $validatedProps = [
            "badge",
            "rank",
            "wins",
            "lost",
            "points",
            "played",
            "name",
            "playedLast24Hours",
            "winstreakCurrent",
            "winstreakHighest",
        ];

        if ($request->properties == null)
        {
            return [];
        }
        
        $newProperties = [];
        foreach($request->properties as $prop)
        {
            if (in_array($prop, $validatedProps))
            {
                $newProperties[] = $prop;
                continue;
            }
        }

        return $newProperties;
    }

    public static function validateColorRequest(Request $request)
    {
        // Handle colour inputs
        $color = "";
        switch($request->color)
        {
            case "pink":
                $color = "pink";
                break;
            case "blue":
                $color= "blue";
                break;
            case "teal":
                $color = "teal";
                break;
            case "green":
                $color = "green";
                break;
            case "red":
                $color = "red";
                break;
            case "purple":
                $color = "purple";
                break;
            case "white":
                $color = "white";
                break;
            default: "";
        }
        return $color;
    }

    public static function validateLayoutRequest(Request $request)
    {
        if ($request->layout == "space-between")
            return "space-between";
        return "";
    }

    public static function validateBorderRequest(Request $request)
    {
        if ($request->border == "no-border")
            return "no-border";
        return "";
    }
    
    public static function validateBrandingRequest(Request $request)
    {
        if ($request->branding == "show-branding")
            return "show-branding";
        return "";
    }
    
    public static function validateSizeRequest(Request $request)
    {
        // Handle size inputs
        $size = "";
        switch($request->size)
        {
            case "md":
                $size = "md";
                break;
            case "lg":
                $size = "lg";
                break;
            case "xl":
                $size= "xl";
                break;
            case "xxl":
                $size = "xxl";
                break;
            default: "";
        }
        return $size;
    }
}