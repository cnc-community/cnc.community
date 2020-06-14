<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeaderboardHistory;
use Illuminate\Pagination\Paginator;

class Leaderboard extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboards';

    public function history()
    {
        return LeaderboardHistory::where("leaderboard_id", $this->id)->first();
    }

    public function data($limit = 200, $offset = 0)
    {
        return LeaderboardData::where("leaderboard_history_id", $this->history()->id)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function dataPaginated($paginate, $limit)
    {
        return LeaderboardData::where("leaderboard_history_id", $this->history()->id)
            ->limit($limit)
            ->paginate($paginate);
    }

    public static function saveRA1vs1Data($result)
    {
        $leaderboard = Leaderboard::where("type", "ra_1vs1")->first();
        $history = $leaderboard->history();
        Leaderboard::saveData($history->id, $result);
    }

    public static function saveTDvs1Data($result)
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        $history = $leaderboard->history();
        Leaderboard::saveData($history->id, $result);
    }

    private static function saveData($historyId, $result)
    {
        $leaderResult = LeaderboardData::where("rank", $result["rank"])
            ->where("leaderboard_history_id", $historyId)
            ->first();

        if ($leaderResult == null)
        {
            $leaderResult = new LeaderboardData();
        }
        
        $leaderResult->leaderboard_history_id = $historyId;
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