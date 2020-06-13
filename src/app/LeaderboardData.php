<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardData extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_data';

    public function player()
    {
        return MatchPlayer::find($this->match_player_id);
    }
}
