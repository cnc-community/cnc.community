<?php

namespace App\Http\Services\Petroglyph;

use App\Constants;
use App\Http\Services\SteamHelper;
use App\SteamLookup;

class PetroglyphSteamProfileService
{
    private SteamHelper $steamHelper;
    private RemastersAPI $remastersAPI;
    private NineBitArmiesAPI $nineBitArmiesAPI;

    public function __construct()
    {
        $this->steamHelper = new SteamHelper();
        $this->remastersAPI = new RemastersAPI();
        $this->nineBitArmiesAPI = new NineBitArmiesAPI();
    }

    public function syncRemastersFromRecentGames()
    {
        $playerIdNames = $this->remastersAPI->fetchNamesFromRecentGames();
        $saved = [];
        foreach ($playerIdNames as $playerId => $name)
        {
            $steamLookup = SteamLookup::where("steam_id", $playerId)->first();
            if ($steamLookup == null)
            {
                $saved[] = $this->saveSteamLookup($playerId, $name, null);
            }
        }
    }

    public function syncNineBitArmiesFromRecentGames()
    {
        $playerIdNames = $this->nineBitArmiesAPI->fetchNamesFromRecentGames();
        $saved = [];
        foreach ($playerIdNames as $playerId => $name)
        {
            $steamLookup = SteamLookup::where("steam_id", $playerId)->first();
            if ($steamLookup == null)
            {
                $saved[] = $this->saveSteamLookup($playerId, $name, null);
            }
        }
    }

    public function syncSteamProfiles(array $steamIds, int $steamAppId)
    {
        // Fetch those steam ids that don't exist in our system
        $steamProfiles = $this->steamHelper->getSteamProfiles($steamAppId, $steamIds);

        foreach ($steamProfiles as $steamProfile)
        {
            $steamLookup = SteamLookup::where("steam_id", $steamProfile["steamid"])->first();
            if ($steamLookup == null)
            {
                $this->saveSteamLookup($steamProfile["steamid"], $steamProfile["personaname"], $steamProfile["avatarfull"]);
            }
        }
    }

    public function saveSteamLookup($steamId, string $name, string $avatar = null)
    {
        $steam = new SteamLookup();
        $steam->steam_id = $steamId;
        $steam->personaname = $name;
        $steam->avatarfull = $avatar;
        $steam->save();
        return $steam;
    }

    public function getSteamProfilesByIds(array $steamIds)
    {
        return SteamLookup::whereIn("steam_id", $steamIds)->select("steam_id", "personaname", "avatarfull")->get();
    }
}
