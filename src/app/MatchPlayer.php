<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MatchPlayer extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'match_players';
    
    public function playerUrlByGameSlug($gameSlug)
    {
        return "/command-and-conquer-remastered/leaderboard/" . $gameSlug . "/player/" . $this->id; 
    }

    public function playerWins()
    {
        $player = Cache::remember("playerWins".$this->id, Constants::getCacheSeconds(), function ()
        {
            return LeaderboardData::where("match_player_id", $this->id)->first();
        });

        if($player)
        {
            return $player->wins;
        }   
        return null; 
    }

    public function playerLosses()
    {
        $player = Cache::remember("playerLosses".$this->id, Constants::getCacheSeconds(), function () 
        {
            return LeaderboardData::where("match_player_id", $this->id)->first();
        });

        if($player)
        {
            return $player->losses;
        }   

        return null; 
    }

    public function playerPoints()
    {
        $player = Cache::remember("playerPoints".$this->id, Constants::getCacheSeconds(), function () 
        {
            return LeaderboardData::where("match_player_id", $this->id)->first();
        });

        if($player)
        {
            return $player->points;
        }   

        return null; 
    }

    public function playerRank($history)
    {
        if ($history == null)
        {
            abort(500);
        }

        $player = Cache::remember("playerRank".$this->id.$history->id, Constants::getCacheSeconds(), function () use ($history)
        {
            return LeaderboardData::where("match_player_id", $this->id)
            ->where("leaderboard_history_id", $history->id)
            ->first();
        });
        
        if ($player)
        {
            return $player->rank;
        }   
        
        return null; 
    }

    public function playerFactionByMatchId($matchId)
    {
        $match = Match::where("matchid", $matchId)->first();
        $players = json_decode($match->players);
        $factions = json_decode($match->factions);
        
        $playerIndex = -1;
        foreach($players as $k => $playerId)
        {
            if ($this->player_id == $playerId)
                $playerIndex = $k;
        }

        return LeaderboardHelper::getFactionById($factions[$playerIndex]);
    }

    public function playerBadge($rank)
    {
        return LeaderboardHelper::getBadgeByRank($rank);
    }
    
    public function playerName()
    {
        return ViewHelper::renderSpecialOctal($this->player_name);
    }

    public static function findPlayer($playerId)
    {
        $player = Cache::remember("findPlayer".$playerId, Constants::getCacheSeconds(), function () use ($playerId)
        {
            return MatchPlayer::where("player_id", $playerId)->first();
        });
        return $player;
    }

    public function leaderboardStats($leaderboardHistory)
    {
        return LeaderboardData::where("match_player_id", "=", $this->id)
            ->where("leaderboard_history_id", $leaderboardHistory->id)
            ->first();
    }

    public static function savePlayer($playerId, $playerName)
    {
        $player = MatchPlayer::where("player_id", $playerId)->first();
        if ($player == null)
        {
            $player = new MatchPlayer();
            $player->player_id = $playerId;
        }
        $player->player_name = $playerName;
        $player->save();
        return $player;
    }

    public function matches($matchType, $pageNumber, $searchQuery, $leaderboardHistoryId)
    {
        // DB::connection('mysql2')->enableQueryLog();
        // $start = microtime(true);
        
        $cacheKey = "playerMatches".$this->player_id.$matchType.$pageNumber.$searchQuery.$leaderboardHistoryId;
        return Cache::remember($cacheKey, Constants::getCacheSeconds(), function () use ($matchType, $searchQuery, $leaderboardHistoryId)
        {
            if ($searchQuery == null)
            {
                return Match::whereJsonContains("players", [$this->player_id])
                    ->where("matchtype", $matchType)
                    ->where("leaderboard_history_id", $leaderboardHistoryId)
                    ->orderBy("starttime", "DESC")
                    ->paginate(20);
            }
            else
            {
                return Match::whereJsonContains("players", [$this->player_id])
                    ->where("matchtype", $matchType)
                    ->where("leaderboard_history_id", $leaderboardHistoryId)
                    ->where("names", "LIKE", "%$searchQuery%")
                    ->orderBy("starttime", "DESC")
                    ->simplePaginate(20);
            }
        });

        // $time = microtime(true) - $start;
        // $queries = DB::connection('mysql2')->getQueryLog();
        // return ["debug" => $queries, "time" => $time];
    }
}
