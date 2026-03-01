<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameStatGraph extends Model
{
    protected $table = 'game_stats_graph';

    public const GAME_STAT_GRAPH_CACHE_3_MONTHS = "GAME_STAT_GRAPH_CACHE_3_MONTHS";
    public const GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_3_MONTHS = "GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_3_MONTHS";

    public const GAME_STAT_GRAPH_CACHE_5_YEARS = "GAME_STAT_GRAPH_CACHE_5_YEARS";
    public const GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_5_YEARS = "GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_5_YEARS";

    public static function createStat($gameStatId, $playersOnline, $steamInGameCount = 0)
    {
        $gameStat = GameStat::where("id", $gameStatId)->first();
        if ($gameStat == null)
        {
            return;
        }

        // Check if created in the last 8 minutes
        $gameStatGraph = GameStatGraph::where("game_stats_id", $gameStat->id)
            ->whereBetween(
                "created_at",
                array(
                    Carbon::now()->subMinutes(8)->toDateTimeString(),
                    Carbon::now()->toDateTimeString()
                )
            )
            ->first();

        if ($gameStatGraph == null)
        {
            $gameStatGraph = new GameStatGraph();
            $gameStatGraph->game_stats_id = $gameStat->id;
            $gameStatGraph->players_online = $playersOnline;
            $gameStatGraph->steam_players_online = $steamInGameCount;
            $gameStatGraph->save();
        }
        return $gameStatGraph;
    }

    public static function deleteOldRecords()
    {
        // Delete anything older than 5 years
        return GameStatGraph::where("created_at", "<=", Carbon::now()->subYears(5)->toDateTimeString())->delete();
    }

    public static function getLast24Hours()
    {
        return GameStatGraph::whereBetween(
            "created_at",
            array(
                Carbon::now()->subDays(1)->toDateTimeString(),
                Carbon::now()->toDateTimeString()
            )
        )
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public static function getLast7Days()
    {
        return GameStatGraph::whereBetween(
            "created_at",
            array(
                Carbon::now()->subDays(7)->toDateTimeString(),
                Carbon::now()->toDateTimeString()
            )
        )
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public static function getLast5Years()
    {
        ini_set('memory_limit', '1024M');

        return GameStatGraph::whereBetween(
            "created_at",
            array(
                Carbon::now()->subYears(5)->toDateTimeString(),
                Carbon::now()->toDateTimeString()
            )
        )
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public static function getLast3Months()
    {
        ini_set('memory_limit', '1024M');

        return GameStatGraph::whereBetween(
            "created_at",
            array(
                Carbon::now()->subMonths(3)->toDateTimeString(),
                Carbon::now()->toDateTimeString()
            )
        )
            ->orderBy("created_at", "DESC")
            ->get();
    }

    /**
     * Get last 3 months of data pre-aggregated into hourly buckets.
     * Returns lightweight stdClass objects instead of Eloquent models.
     */
    public static function getLast3MonthsHourly()
    {
        return DB::table('game_stats_graph')
            ->select(
                'game_stats_id',
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00') as hour_bucket"),
                DB::raw('ROUND(AVG(players_online)) as players_online'),
                DB::raw('ROUND(AVG(steam_players_online)) as steam_players_online')
            )
            ->whereBetween('created_at', [
                Carbon::now()->subMonths(3)->toDateTimeString(),
                Carbon::now()->toDateTimeString(),
            ])
            ->groupBy('game_stats_id', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00')"))
            ->orderBy('hour_bucket', 'ASC')
            ->get();
    }

    public function getOnlineCount()
    {
        return $this->players_online;
    }

    public function getAbbreviation()
    {
        return $this->abbrev;
    }
}
