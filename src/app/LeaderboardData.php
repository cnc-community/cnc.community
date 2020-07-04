<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LeaderboardData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_data';

    public function player()
    {
        return MatchPlayer::where("id", $this->match_player_id)->first();
    }

    public static function findPlayerData($playerId)
    {
        $playerData = Cache::remember("findPlayerData".$playerId, Constants::getCacheSeconds(), function () use($playerId) 
        {
            return LeaderboardData::where("match_player_id", $playerId)->first();
        });
        return $playerData;
    }
}
