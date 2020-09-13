<?php

namespace App\Http\Services;

use App\MatchPlayer;

interface LeaderboardRowProfileInterface
{
    public function id(): int;
    public function rank(): int;
    public function playerName(): string;
    public function wins(): int;
    public function losses(): int;
    public function points(): int;
    public function avatarImageUrl();
}

class LeaderboardRowProfile implements LeaderboardRowProfileInterface
{
    public function __construct($leaderboardData)
    {
        foreach($leaderboardData as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function id(): int { return $this->id; }
    public function playerName(): string { return ""; }
    public function rank(): int { return $this->rank; }
    public function wins(): int { return $this->wins; }
    public function losses(): int { return $this->losses; }
    public function points(): int { return round($this->points); }
    public function totalGames(): int { return $this->wins + $this->losses; }
    public function winRatio(): int 
    { 
        return 
        (
            round(($this->wins / $this->totalGames() * 100))
        ); 
    }
    public function avatarImageUrl() 
    { 
        $player = MatchPlayer::findPlayer($this->player_id);
        if ($player == null)
        {
            return "";
        }
        
        $avatar = $player->getSteamProfile();
        return $avatar["steamAvatarUrl"]; 
    }
}