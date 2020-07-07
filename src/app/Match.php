<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'matches';

    public const TD_1vs1 = 1;
    public const RA_1vs1 = 2;

    public static function quickStats($matchType)
    {
        return Match::orderBy("matchduration", "DESC")
            ->limit(5)
            ->get();
    }

    public static function getMatchTypeByGameSlug($gameSlug)
    {
        if ($gameSlug == "red-alert")
        {
            return Match::RA_1vs1;
        }
        else if ($gameSlug == "tiberian-dawn")
        {
            return Match::TD_1vs1;
        }
    }
    
    public function startTime() { return date("M d Y H:i:s", $this->starttime); }
    public function matchDuration() 
    { 
        return date("H:i:s",$this->matchduration); 
    }
    public function players()
    { 
        $players = json_decode($this->players);
        return MatchPlayer::whereIn("player_id", $players)->get();
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

    public static function createMatch($matchResponse)
    {
        $match = new Match();
        $match->elos = json_encode($matchResponse["elos"]);
        $match->names = json_encode($matchResponse["names"]);
        $match->teams = json_encode($matchResponse["teams"]);
        $match->avgelo = $matchResponse["avgelo"];
        $match->cdnurl = $matchResponse["cdnurl"];
        $match->colors = json_encode($matchResponse["colors"]);
        $match->mapname = $matchResponse["mapname"];
        $match->matchid = $matchResponse["matchid"];
        $match->matchtype = $matchResponse["matchtype"];
        $match->starttime = $matchResponse["starttime"];
        $match->players = json_encode($matchResponse["players"]);
        $match->factions = json_encode($matchResponse["factions"]);
        $match->locations = json_encode($matchResponse["locations"]);
        $match->wasrandom = json_encode($matchResponse["wasrandom"]);
        $match->aisettings = json_encode($matchResponse["aisettings"]);
        $match->matchduration = $matchResponse["matchduration"];
        $match->winningteamid = $matchResponse["winningteamid"];
        $match->extramatchsettings = json_encode($matchResponse["extramatchsettings"]);
        $match->extraperplayersettings = json_encode($matchResponse["extraperplayersettings"]);
        $match->save();
    }

    public static function savePlayersFromMatch($matchResponse)
    {
        foreach($matchResponse["players"] as $key => $playerSteamOriginId)
        {
            $playerName = $matchResponse["names"][$key];

            MatchPlayer::savePlayer($playerSteamOriginId, $playerName);
        }
    }
}
