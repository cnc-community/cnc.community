<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'matches';

    public static function checkMatchExists($matchId)
    {
        return Match::where("matchid", $matchId)->first();
    }

    public static function createMatch($matchResponse)
    {
        $match = new Match();
        $match->matchid = $matchResponse["matchid"];
        $match->mapname = $matchResponse["mapname"];
        $match->raw = json_encode($matchResponse);
        $match->save();
    }

    public static function savePlayersFromMatch($matchResponse)
    {
        $player1Id = $matchResponse["players"][0];
        $player1Name = $matchResponse["names"][0];

        MatchPlayer::savePlayer($player1Id, $player1Name);

        $player2Id = $matchResponse["players"][1];
        $player2Name = $matchResponse["names"][1];

        MatchPlayer::savePlayer($player2Id, $player2Name);
    }
}
