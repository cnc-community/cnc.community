<?php

namespace App\Http\Services;

interface LeaderboardProfileInterface
{
    public function id(): int;
    public function rank(): int;
    public function wins(): int;
    public function losses(): int;
    public function points(): int;
}

class LeaderboardProfile implements LeaderboardProfileInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function id(): int { return $this->id; }
    public function rank(): int { return $this->rank; }
    public function wins(): int { return $this->wins; }
    public function losses(): int { return $this->losses; }
    public function points(): int { return round($this->points); }
    public function totalGames(): int { return $this->wins + $this->losses; }
    public function winRatio(): int 
    { 
        return 
        (
            round(($this->wins/$this->totalGames() * 100))
        ); 
    }
}