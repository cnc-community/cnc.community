<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatchPlayerSteamProfile extends Model
{
    protected $table = 'match_players_steam_profile';
    protected $connection = 'mysql2';

    public static function saveProfile($steamId, $personaName, $avatar, $avatarMedium, $avatarFull, $avatarHash)
    {
        $player = MatchPlayer::where("player_id", $steamId)->first();
        if ($player)
        {
            $steamProfile = MatchPlayerSteamProfile::where("match_player_id", $player->id)->first();
            if ($steamProfile == null)
            {
                $steamProfile = new MatchPlayerSteamProfile();
            }
            $steamProfile->match_player_id = $player->id;
            $steamProfile->avatar = $avatar;
            $steamProfile->steam_name = $personaName;
            $steamProfile->avatar_medium = $avatarMedium;
            $steamProfile->avatar_full = $avatarFull;
            $steamProfile->avatar_hash = $avatarHash;
            $steamProfile->save();
        }
    }
}
