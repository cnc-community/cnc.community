<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LeaderboardMatchHistory extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'leaderboard_match_history';
    
    public function matchType(): string 
    {
        switch($this->matchtype)
        {
            case 1:
                return MatchData::TD_1vs1;

            case 2: 
                return MatchData::RA_1vs1;
        }
        return $this->matchtype;
    }
    
    public function startTime() { return date("M d Y H:i:s", $this->starttime); }
    public function matchDuration() { return date("H:i:s", $this->matchduration); }

    public function players()
    { 
        $players = json_decode($this->players);
        return MatchPlayer::whereIn("player_id", $players)->get();
    }

    public function teams() 
    {
        $teamsArr = json_decode($this->teams);
        $playersArr = json_decode($this->players);

        $teams = [];
        foreach($teamsArr as $k => $teamId)
        {
            $player = MatchPlayer::findPlayer($playersArr[$k]);
            $teams[$teamId][] = $player;            
        }
        return $teams;
    }

    public function winningTeamId(){return $this->winningteamid;}
    public function mapInternalName(): string { return $this->mapname; }
    public function mapName(): string 
    {
        $map = Map::where("internal_name", $this->mapname)->first();
        if ($map)
        {
            return $map->map_name;
        } 
        return $this->mapname;
    }
    public function factions(): array { return $this->factions; }

    public static function saveGame($matchId, $matchPlayerId)
    {
        $match = LeaderboardMatchHistory::where("match_id", $matchId)
            ->where("match_player_id", $matchPlayerId)
            ->first();

        if ($match == null)
        {
            $match = new LeaderboardMatchHistory();
            $match->match_player_id = $matchPlayerId;
            $match->match_id = $matchId;
            $match->save();
        }
    }

    public static function saveGames($matchIds, $matchPlayerId)
    {
        // Get the ids we know exist in the fast way possible
        $matchExists = LeaderboardMatchHistory::whereIntegerInRaw("match_id", $matchIds)
            ->where("match_player_id", "=", $matchPlayerId)
            ->select("match_id")
            ->get()
            ->toArray();

        // Flatten into just the match_ids's
        $existingMatchIds = [];
        foreach($matchExists as $match)
        {
            $existingMatchIds[] = $match["match_id"];
        }

        // Compare the two matchId arrays and create a query for the ids we want to insert
        $idsToInsert = array_merge(array_diff($matchIds, $existingMatchIds));
        
        $query = [];
        foreach($idsToInsert as $id)
        {
            $query[] = [
                'match_id' => $id,
                'match_player_id' => $matchPlayerId
            ];
        }

        LeaderboardMatchHistory::insert($query);
    }
}
