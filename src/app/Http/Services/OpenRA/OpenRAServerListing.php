<?php

namespace App\Http\Services\OpenRA;

interface OpenRAServerListingInterface
{
    public function id(): string;
    public function name(): string;
    public function mod(): string;
    public function modtitle(): string;
    public function players(): int;
    public function spectators(): int;
}

class OpenRAServerListing implements OpenRAServerListingInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function id(): string { return $this->id;}
    public function name(): string { return $this->name;}
    public function mod(): string { return $this->mod;}
    public function modtitle(): string { return $this->modtitle;}
    public function players(): int { return $this->players;}
    public function spectators(): int { return $this->spectators;}
    public function totalPlayers(): int 
    {
        return $this->players += $this->spectators;
    }
}