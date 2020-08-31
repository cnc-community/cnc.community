<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameStatGraph extends Model
{
    protected $table = 'game_stats_graph';

    public static function createStat($gameStatId, $playersOnline)
    {
        // Always ensure we only keep the data we want
        GameStatGraph::deleteOldRecords();

        $gameStat = GameStat::where("id",$gameStatId)->first();
        if ($gameStat == null)
        {
            Log::info("Game Stat not found could not save graph record");
            return;
        }
        
        // Check if created in the last 8 minutes
        $gameStatGraph = GameStatGraph::where("game_stats_id", $gameStat->id)
            ->whereBetween("created_at", 
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
            $gameStatGraph->save();
        }
        return $gameStatGraph;
    }
    
    private static function deleteOldRecords()
    {
        // Delete anything older than 24hours
        return GameStatGraph::where("created_at", "<=", Carbon::now()->subDays(1)->toDateTimeString())->delete();
    }

    public static function getLast24Hours()
    {
        return GameStatGraph::whereBetween("created_at", 
            array(
                Carbon::now()->subDays(1)->toDateTimeString(), 
                Carbon::now()->toDateTimeString()
            )
        )
        ->get();
    }

    public function getOnlineCount() { return $this->players_online; }
    public function getAbbreviation() { return $this->abbrev; }
}