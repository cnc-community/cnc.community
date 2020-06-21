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
        return gmdate("H:i:s", $this->starttime); 
    }
    public function matchDuration() 
    { 
        return gmdate("H:i:s", $this->matchduration); 
    }
    public function winningteamid(): int { return $this->winningteamid; }
    public function mapName(): string 
    {
        $map = Map::where("internal_name", $this->mapname)->first();
        if ($map)
        {
            return $map->map_name;
        } 
        return $this->mapname;
    }

    public function mapInternalName(): string 
    {
        return $this->mapname;
    }

    public function player1Colour(): string 
    {
        return $this->getColourById($this->colors[0]);
    }

    public function player2Colour(): string 
    {
        return $this->getColourById($this->colors[1]);
    }

    public function player1Faction(): string 
    {
        return $this->getFactionById($this->factions[0]);
    }

    public function player2Faction(): string 
    {
        return $this->getFactionById($this->factions[1]);
    }

    private function getColourById($id): string
    {
        switch($id)
        {
            case 0:
                return "yellow";
            case 1:
                return "blue";
            case 2: 
                return "red";
            case 3:
                return "green";
            case 4:
                return "orange";
            case 5:
                return "teal";
            case 6:
                return "purple";
            case 7:
                return "pink";
        }
        return "";
    }

    private function getFactionById($id): string 
    {
        switch($id)
        {
            case 0:
                return "spain";
            case 1:
                return "greece";
            case 2:
                return "ussr";
            case 3:
                return "england";
            case 4:
                return "ukraine";
            case 5:
                return "germany";
            case 6:
                return "france";
            case 7:
                return "turkey";
        }
        return "";
    }
}