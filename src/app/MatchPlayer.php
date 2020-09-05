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

    public function playerWinStreak($matchType, $leaderboardHistoryId)
    {
        $matches = Match::where("matchtype", $matchType)
            ->where("leaderboard_history_id", $leaderboardHistoryId)
            ->whereRaw("MATCH (players) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($this->player_id))
            ->orderBy("starttime", "DESC")
            ->get();

        $winningStreaks = [];
        $winningCount = 0;
        $attempts = 0;

        foreach($matches as $match)
        {
            $players = json_decode($match->players);

            foreach($players as $key => $playerId)
            {
                $teams = json_decode($match->teams);
                $teamId = $teams[$key];

                if ($playerId == $this->player_id)
                {
                    if ($teamId == $match->winningteamid)
                    {
                        // We won the match, add to current streak
                        $winningCount++;
                        $winningStreaks[$attempts] = $winningCount;
                    }
                    else
                    {
                        // We lost add our latest win streak and reset
                        $winningStreaks[$attempts] = $winningCount;
                        $attempts++;
                        $winningCount = 0;
                    }
                }
            }
        }

        return [
            "highest" => count($winningStreaks) > 0 ? max($winningStreaks) : 0,
            "current" => count($winningStreaks) > 0 ? $winningStreaks[0] : 0
        ];
    }

    public function playerGames24Hours($matchType, $leaderboardHistoryId)
    {
        $last24Hours = time() - (24 * 60 * 60);

        return Cache::remember("playerGames24Hours".$this->id.$matchType.$leaderboardHistoryId, 480, function ()
            use($matchType, $leaderboardHistoryId, $last24Hours)
        {
            return Match::where("matchtype", $matchType)
                ->where("leaderboard_history_id", $leaderboardHistoryId)
                ->whereRaw("MATCH (players) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($this->player_id))
                ->where('starttime', '>=', $last24Hours)
                ->count();
        });
    }

    public function playerRank($history)
    {
        if ($history == null)
        {
            abort(500);
        }

        $player = Cache::remember("playerRank".$this->id.$history->id, 480, function () use ($history)
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
        $player = Cache::remember("findPlayer".$playerId, 480, function () use ($playerId)
        {
            return MatchPlayer::where("player_id", $playerId)->first();
        });
        return $player;
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
        return Cache::remember($cacheKey, 1800, function () use ($matchType, $searchQuery, $leaderboardHistoryId)
        {
            if ($searchQuery == null)
            {
                return Match::where("matchtype", $matchType)
                    ->where("leaderboard_history_id", $leaderboardHistoryId)
                    ->whereRaw("MATCH (players) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($this->player_id))
                    ->orderBy("starttime", "DESC")
                    ->paginate(20);
            }
            else
            {
                return Match::whereJsonContains("players", [$this->player_id])
                    ->where("matchtype", $matchType)
                    ->where("leaderboard_history_id", $leaderboardHistoryId)
                    ->whereRaw("MATCH (names) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($searchQuery))
                    ->orderBy("starttime", "DESC")
                    ->paginate(20);
            }
        });

        // $time = microtime(true) - $start;
        // $queries = DB::connection('mysql2')->getQueryLog();
        // return ["debug" => $queries, "time" => $time];
    }

    // https://stackoverflow.com/questions/52852264/laravel-5-full-text-search
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
            * applying + operator (required word) only big words
            * because smaller ones are not indexed by mysql
            */
            if (strlen($word) >= 3) {
                $words[$key] = '*' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }


    /**
     * API Endpoint for generating webview
     */
    public static function profile($gameSlug, $playerId)
    {
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason($matchType);
        if ($leaderboardHistory == null)
        {
            return null;
        }

        $playerData = LeaderboardData::findPlayerData($playerId, $leaderboardHistory->id);
        if ($playerData == null)
        {
            return null;
        }

        $matchPlayer = MatchPlayer::find($playerData->match_player_id);
        if ($matchPlayer == null)
        {
            return null;
        }

        $playerData["name"] = $matchPlayer->playerName();
        return $playerData;
    }
}
