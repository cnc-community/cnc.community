<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return LeaderboardData::where("match_player_id", $playerId)->first();
    }

    public function playerName()
    {
        $username = $this->player()->player_name;
        return ViewHelper::renderSpecialOctal($username);
    }
}
