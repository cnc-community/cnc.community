<?php

namespace App\Http\Services;

interface LeaderboardProfileStatsInterface
{
    public function playerFactionStats(): array;
    public function winStreakCurrent(): int;
    public function winStreakHighest(): int;
    public function gamesPlayedLast24Hours(): int;
}

class LeaderboardProfileStats implements LeaderboardProfileStatsInterface
{
    private $playerFactionStats;

    public function __construct($factions, $winStreak, $gamesLast24Hours, $last5Games)
    {
        foreach($factions as $faction => $factionStats)
        {
            $this->buildFactionStats($faction, $factionStats);
        }

        $this->{"winStreakHighest"}  = $winStreak["highest"];
        $this->{"winStreakCurrent"}  = $winStreak["current"];
        $this->{"gamesPlayedLast24Hours"} = $gamesLast24Hours;
        $this->{"playerLast5GameStates"} = $last5Games;
    }

    private function buildFactionStats($faction, $factionStats)
    {
        $winRatio = 0;
        if (isset($factionStats["wins"]) && isset($factionStats["total"]))
        {
            $winRatio = round(($factionStats["wins"] / $factionStats["total"] * 100));
        }
        $this->playerFactionStats[$faction] = new FactionStat($factionStats, $winRatio);
    }

    public function playerLast5GameStates(): array { return $this->playerLast5GameStates; }
    public function playerFactionStats(): array { return $this->playerFactionStats; }
    public function winStreakCurrent(): int { return $this->winStreakCurrent; }
    public function winStreakHighest(): int { return $this->winStreakHighest; }
    public function gamesPlayedLast24Hours(): int { return $this->gamesPlayedLast24Hours; }
}

class FactionStat
{
    public function __construct($stats, $winRatio)
    {
        foreach($stats as $k => $v)
        {
            $this->{$k} = $v;
        }

        $this->winRatio = $winRatio;
    }

    public function wins(): int { return isset($this->wins) ? $this->wins : 0; }
    public function losses(): int { return isset($this->losses) ? $this->losses: 0; }
    public function total(): int { return $this->total; }
    public function winRatio(): int { return $this->winRatio; }
}