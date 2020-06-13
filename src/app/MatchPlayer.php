<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchPlayer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'match_players';

    public static function findPlayer($playerId)
    {
        return MatchPlayer::where("player_id", $playerId)->first();
    }

    public static function savePlayer($playerId, $playerName)
    {
        $player = MatchPlayer::where("player_id", $playerId)->first();
        if ($player == null)
        {
            $player = new MatchPlayer();
            $player->player_id = $playerId;
            $player->player_name = $playerName;
            $player->save();
        }
        return $player;
    }
}
