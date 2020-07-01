<?php

namespace App;

class MatchData
{
    public const RA_1vs1 = "RA_1vs1";
    public const TD_1vs1 = "TD_1vs1";

    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

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
    
    public function players(): array { return $this->players; }
    public function factions(): array { return $this->factions; }
    public function startTime() 
    { 
        return date("M d Y H:i:s", $this->starttime); 
    }
    public function matchDuration() 
    { 
        return date("H:i:s", $this->matchduration); 
    }
    public function winningTeamId(): int { return $this->winningteamid; }
    public function mapName(): string 
    {
        $map = Map::where("internal_name", $this->mapname)->first();
        if ($map)
        {
            return $map->map_name;
        } 
        return $this->mapname;
    }
    public function player1() { return MatchPlayer::findPlayer($this->players[0]); }
    public function player2() { return MatchPlayer::findPlayer($this->players[1]); }

    public function winningPlayer() 
    {
        $playerIndex = $this->teams[$this->winningteamid];
        return MatchPlayer::findPlayer($this->players[$playerIndex]);
    }

    public function player1Faction(): string { return $this->getFactionById($this->factions[0]); }
    public function player2Faction(): string { return $this->getFactionById($this->factions[1]); }
    public function mapInternalName(): string { return $this->mapname; }

    private function getFactionById($id): string 
    {
        switch($id)
        {
            case -1:
                return "invalid";
            case 0:
                return "gdi";
            case 1:
                return "nod";
            case 2:
                return "spain";
            case 3:
                return "greece";
            case 4:
                return "ussr";
            case 5:
                return "england";
            case 6:
                return "ukraine";
            case 7:
                return "germany";
            case 8:
                return "france";
            case 9:
                return "turkey";
            case 42:
                return "random";
        }
        return "random";
    }
}