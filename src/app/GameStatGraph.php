<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameStatGraph extends Model
{
    protected $table = 'game_stats_graph';

    public const GAME_STAT_GRAPH_CACHE_5_YEARS = "GAME_STAT_GRAPH_CACHE_5_YEARS";
    public const GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_5_YEARS = "GAME_STAT_STEAM_IN_GAME_GRAPH_CACHE_5_YEARS";

    public static function createStat($gameStatId, $playersOnline, $steamInGameCount = 0)
    {
        // Always ensure we only keep the data we want
        GameStatGraph::deleteOldRecords();

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

    private static function deleteOldRecords()
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

    public function getOnlineCount()
    {
        return $this->players_online;
    }

    public function getAbbreviation()
    {
        return $this->abbrev;
    }
}
