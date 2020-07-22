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

    public function history()
    {
        return LeaderboardHistory::where("leaderboard_id", $this->id)->first();
    }

    public static function getLeadeboardByMatchType($matchType)
    {
        return Leaderboard::where("matchtype", $matchType)->first();
    }

    public static function getHistoryByDateAndMatchType($requestedCarbonDate, $matchType)
    {       
        // Debug
        // $requestedCarbonDate = Carbon::create(2021, 1, 0,0,0)->startOfMonth();

        $leaderboard = Leaderboard::where("matchtype", $matchType)->first();
        
        $startDate = $requestedCarbonDate->toImmutable()->toDateTimeString();
        $endDate = $requestedCarbonDate->toImmutable()->endOfMonth()->addMonths(3)->toDateTimeString();

        return LeaderboardHistory::where("end", ">=", $startDate)
            ->where("end", "<=", $endDate)
            ->where("leaderboard_id", $leaderboard->id)
            ->first();
    }

    public static function dataPaginated($cacheKey, $date, $matchType, $searchQuery, $paginate, $limit)
    {
        $history = Leaderboard::getHistoryByDateAndMatchType($date, $matchType);
        $paginatedCacheKey = "Leaderboard.dataPaginated".$paginate.$limit.$cacheKey.$searchQuery;

        if ($history == null)
        {
            return [];
        }

        return LeaderboardData::where("leaderboard_history_id", $history->id)
            ->leftJoin("match_players as mp", "mp.id", "leaderboard_data.match_player_id")
            ->where("mp.player_name", "LIKE", "%$searchQuery%")
            ->select("mp.player_name", "mp.player_id", "leaderboard_data.*")
            ->limit($limit)
            ->paginate($paginate);
        return Cache::remember($paginatedCacheKey, 1200, function () use($history, $paginate, $limit, $searchQuery)
        {
        });
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
