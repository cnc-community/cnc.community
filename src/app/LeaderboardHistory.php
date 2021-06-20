<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaderboardHistory extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_history';

    public static function getActiveSeasonByLeaderboard($leaderboard)
    {
        return LeaderboardHistory::where("leaderboard_id", $leaderboard->id)
            ->where("active", 1)
            ->first();
    }

    public function getPreviousSeasons()
    {
        return LeaderboardHistory::where("leaderboard_id", $this->leaderboard_id)
            ->where("active", 0)
            ->get();
    }

    # Accessors 
    public function isActiveSeason()
    {
        return $this->active == 1;
    }

    /**
     * Get season id - used for interacting with leaderboard api
     * @return string 
     */
    public function getSeasonId(): ?string
    {
        return $this->season_id;
    }
}
