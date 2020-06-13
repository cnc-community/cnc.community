<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard';

    public static function storeResult($result)
    {
        $leaderResult = Leaderboard::where("rank", $result["rank"])->first();
        if ($leaderResult == null)
        {
            $leaderResult = new Leaderboard();
        }
        $leaderResult->rank = $result["rank"];
        $leaderResult->wins = $result["wins"];
        $leaderResult->losses = $result["loses"];
        $leaderResult->points = $result["points"];

        $player = MatchPlayer::findPlayer($result["steamids"][0]);
        if ($player)
        {
            $leaderResult->match_player_id = $player->id;
        }

        $leaderResult->save();
    }
}
