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
    public function starttime(): float { return $this->starttime; }
    public function matchduration(): float { return $this->starttime; }
    public function winningteamid(): int { return $this->starttime; }
}