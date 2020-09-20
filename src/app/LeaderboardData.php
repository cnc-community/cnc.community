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

    public static function findPlayerData($playerId, $leaderboardHistoryId)
    {
        return LeaderboardData::where("match_player_id", $playerId)
            ->where("leaderboard_history_id", $leaderboardHistoryId)
            ->first();
    }

    public static function getLeaderboardPlayers($leaderboardHistoryId, $limit=200, $offset=0)
    {
        return LeaderboardData::where("leaderboard_history_id", $leaderboardHistoryId)
            ->leftJoin("match_players", "match_players.id", "=", "leaderboard_data.match_player_id")
            ->limit($limit)
            ->offset($offset)
            ->get();
    }
}
