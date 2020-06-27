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

    public function playerBadge()
    {
        /*
        1 >1750
        2 <1750
        3 <1600
        4 <1450
        5 <1300
        6 <1150
        */
        $path = "/assets/images/leaderboard/";

        if ($this->points > 1750)
        {
            return [
                "image" => $path."general.png",
                "rank" => "General"
            ];
        }
        else if ($this->points < 1750 && $this->points > 1600)
        {
            return [
                "image" => $path."colonel.png",
                "rank" => "Colonel"
            ];
        }
        else if ($this->points < 1600 && $this->points > 1450)
        {
            return [
                "image" => $path."major.png",
                "rank" => "Major"
            ];
        }
        else if ($this->points < 1450 && $this->points > 1300)
        {
            return [
                "image" => $path."captain.png",
                "rank" => "Captain"
            ];
        }
        else if ($this->points < 1300 && $this->points > 1150)
        {
            return [
                "image" => $path."lieutenant.png",
                "rank" => "Lieutenant"
            ];
        }
        else if ($this->points < 1150)
        {
            return [
                "image" => $path."sergeant.png",
                "rank" => "Sergeant"
            ];
        }

        return null;
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
