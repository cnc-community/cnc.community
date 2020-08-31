<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeaderboardHistory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public static function getActiveLeaderboardSeason($matchType)
    {       
        $leaderboard = Leaderboard::where("matchtype", $matchType)->first();
        if ($leaderboard == null)
        {
            Log::info("Leaderboard was null", $matchType);
            return null;
        }
        
        // $startDate = $requestedCarbonDate->toImmutable()->toDateTimeString();
        // $endDate = $requestedCarbonDate->toImmutable()->endOfMonth()->addMonths(3)->toDateTimeString();
        
        // year, month, day, hour, minute, second
        // Temp patch for now
        $startDate = $requestedCarbonDate->toImmutable()->toDateTimeString();

        $history = LeaderboardHistory::where("start", ">=", $startDate)
            ->where("leaderboard_id", $leaderboard->id)
            ->first();

        return $history;
    }

    public static function dataPaginated($cacheKey, $date, $matchType, $searchQuery, $paginate, $limit)
    {
        $history = Leaderboard::getActiveLeaderboardSeason($date, $matchType);
        $paginatedCacheKey = "Leaderboard.dataPaginated".$paginate.$date.$limit.$cacheKey.$searchQuery;

        if ($history == null)
        {
            return [];
        }
        
        return Cache::remember($paginatedCacheKey, 480, function () use($history, $paginate, $limit, $searchQuery)
        {
            return LeaderboardData::where("leaderboard_history_id", $history->id)
                ->leftJoin("match_players as mp", "mp.id", "leaderboard_data.match_player_id")
                ->where("mp.player_name", "LIKE", "%$searchQuery%")
                ->select("mp.player_name", "mp.player_id", "leaderboard_data.*")
                ->limit($limit)
                ->paginate($paginate);
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

    public static function stats($matchType, $historyId)
    {
        // DB::connection('mysql2')->enableQueryLog();
        // $start = microtime(true);

        $statsLast24Hours = Cache::remember("last24Hours".$matchType.$historyId, 3600, function () use($matchType, $historyId)
        {
            $last24Hours = time() - (24 * 60 * 60);
            return Leaderboard::matchesByTime($matchType, $historyId, $last24Hours);
        });

        return [
            "matchesPlayedLast24hours" => $statsLast24Hours
        ];

        // $time = microtime(true) - $start;
        // $queries = DB::connection('mysql2')->getQueryLog();
        // return ["debug" => $queries, "time" => $time];
    }

    private static function matchesByTime($matchType, $historyId, $time)
    {
        return Match::where("matchtype", $matchType)
            ->where("leaderboard_history_id", $historyId)
            ->where('starttime', '>=', $time)
            ->count();
    }
}
