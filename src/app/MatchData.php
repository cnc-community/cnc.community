<?php

namespace App;

class MatchData
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
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
}