<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchPlayer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'match_players';

    public function playerName()
    {
        return ViewHelper::renderSpecialOctal($this->player_name);
    }

    public static function findPlayer($playerId)
    {
        return MatchPlayer::where("player_id", $playerId)->first();
    }

    public function leaderboardStats($leaderboardHistory)
    {
        return LeaderboardData::where("match_player_id", "=", $this->id)
            ->where("leaderboard_history_id", $leaderboardHistory->id)
            ->first();
    }

    public static function savePlayer($playerId, $playerName)
    {
        $player = MatchPlayer::where("player_id", $playerId)->first();
        if ($player == null)
        {
            $player = new MatchPlayer();
            $player->player_id = $playerId;
        }
        $player->player_name = $playerName;
        $player->save();
        return $player;
    }

    public function matches()
    {
        return LeaderboardMatchHistory::where("match_player_id", $this->id)
            ->join("matches", "matches.matchid", "=", "leaderboard_match_history.match_id")
            ->orderBy("match_id", "DESC")
            ->get();
    }
}
