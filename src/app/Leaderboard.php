<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeaderboardHistory;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class Leaderboard extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboards';

    public function history($date = null)
    {
        // $date = Carbon::create($year, $month, 1, 0);

        $date = Carbon::now();
        $start = $date->startOfMonth()->toDateTimeString();
        $end = $date->endOfMonth()->toDateTimeString();

        $h= LeaderboardHistory::where("leaderboard_id", $this->id)
            ->where("start", ">=", $start)
            ->first();

        dd($h);
    }

    public function data($cacheKey, $searchQuery, $limit = 200, $offset = 0)
    {
        return Cache::remember("Leaderboard.data".$limit.$offset.$cacheKey.$searchQuery, 1200, 
        function () use($limit, $offset, $searchQuery)
        {
            // 20 minutes cache
            return LeaderboardData::where("leaderboard_history_id", $this->history()->id)
                ->leftJoin("match_players as mp", "mp.id", "leaderboard_data.match_player_id")
                ->where("mp.player_name", "LIKE", "%$searchQuery%")
                ->select("mp.player_name", "mp.player_id", "leaderboard_data.*")
                ->offset($offset)
                ->limit($limit)
                ->get();
        });
    }

    public function dataPaginated($cacheKey, $searchQuery, $paginate, $limit)
    {
        return Cache::remember("Leaderboard.dataPaginated".$paginate.$limit.$cacheKey.$searchQuery, 1200, function () 
            use($paginate, $limit, $searchQuery)
        {
            // 20 minutes cache
            return LeaderboardData::where("leaderboard_history_id", $this->history()->id)
                ->leftJoin("match_players as mp", "mp.id", "leaderboard_data.match_player_id")
                ->where("mp.player_name", "LIKE", "%$searchQuery%")
                ->select("mp.player_name", "mp.player_id", "leaderboard_data.*")
                ->limit($limit)
                ->paginate($paginate);
        });
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

    public static function saveData($historyId, $result)
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
