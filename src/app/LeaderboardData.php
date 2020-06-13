<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_data';

    public function player()
    {
        $player = MatchPlayer::where("id", $this->match_player_id)->first();
        if ($player)
        {
            return ViewHelper::renderSpecialOctal($player->player_name);
        }
        return "";
    }
}
