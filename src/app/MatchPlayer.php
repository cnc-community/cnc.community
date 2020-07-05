<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    public function playerRank()
    {
        $player = Cache::remember("playerRank".$this->id, Constants::getCacheSeconds(), function () 
        {
            return LeaderboardData::where("match_player_id", $this->id)->first();
        });
        
        if($player)
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

    public function matches($page)
    {
        $matches = Cache::remember("playerMatches".$this->player_id.$page, Constants::getCacheSeconds(), function () 
        {
            return Match::whereJsonContains("players", [$this->player_id])
                ->where("matchtype", 8)
                ->paginate(10);
        });
        return $matches;
    }
}
