<?php

namespace App\Http\Services;

use App\LeaderboardHelper;

interface LeaderboardProfileInterface
{
    public function id(): int;
    public function rank(): int;
    public function wins(): int;
    public function losses(): int;
    public function points(): int;
    public function badge();
    public function avatarSteamUrl();
    public function avatarImageUrl();
    public function profileUrl(): string;
}

class LeaderboardProfile implements LeaderboardProfileInterface
{
    private $id = -1;
    private $rank = -1;
    private $wins = 0;
    private $losses = 0;
    private $points = 0;

    public function __construct($leaderboardData, $avatarSteamUrl, $avatarImageUrl, $profileUrl)
    {
        foreach($leaderboardData as $k => $v) 
        {
            $this->{$k} = $v;
        }
        $this->avatarSteamUrl = $avatarSteamUrl;
        $this->avatarImageUrl = $avatarImageUrl;
        $this->profileUrl = $profileUrl;
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
            round(($this->wins / $this->totalGames() * 100))
        ); 
    }
    public function badge() 
    {
        return new LeaderboardBadge(LeaderboardHelper::getBadgeByRank($this->rank));
    }
    public function avatarSteamUrl() { return $this->avatarSteamUrl; }
    public function avatarImageUrl() { return $this->avatarImageUrl; }
    public function profileUrl():string { return $this->profileUrl; }
}

class LeaderboardBadge
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function badgeImage()
    {
        return $this->image;
    }

    public function badgeTitle()
    {
        return $this->rank;
    }
}