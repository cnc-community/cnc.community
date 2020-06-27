<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardMatchHistory extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_match_history';

    public static function saveGame($matchId, $matchPlayerId)
    {
        $matchExists = LeaderboardMatchHistory::where("match_id", $matchId)
            ->where("match_player_id", $matchPlayerId)
            ->first();

        if ($matchExists == null)
        {
            $matchHistory = new LeaderboardMatchHistory();
            $matchHistory->match_player_id = $matchPlayerId;
            $matchHistory->match_id = $matchId;
            $matchHistory->save();
        }
    }
}
