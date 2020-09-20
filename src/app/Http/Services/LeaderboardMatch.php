<?php

namespace App\Http\Services;

use App\LeaderboardHelper;
use App\Map;

interface MatchInterface
{
    public function id(): int;
    public function matchType(): int;
    public function matchId(): int;
    public function mapName(): string;
    public function names(): array;
    public function players(): array;
    public function factions(): array;
    public function locations(): array;
    public function wasRandom(): array;
    public function winningTeamId(): int;
    public function matchDuration(): string;
    public function startTime(): string;
    public function leaderboardHistoryId(): int;
    public function extraPerPlayerSettings(): array;
    public function extraMatchSettings(): array;
    public function mapPreview(): string;
}

class LeaderboardMatch implements MatchInterface
{
    public function __construct($json)
    {
        foreach($json as $k => $v) 
        {
            $this->{$k} = $v;
        }
    }

    public function id(): int { return $this->id; }
    public function matchType(): int { return $this->matchtype; }
    public function matchId(): int { return $this->matchId; }
    public function mapName(): string 
    { 
        $map = Map::where("internal_name", $this->mapname)->first();
        if ($map)
        {
            return $map->map_name;
        } 
        return $this->mapname; 
    }
    public function mapPreview(): string 
    {
        return LeaderboardHelper::mapPreviewByInternalName($this->mapname);
    }
    public function matchReplayUrl(): string 
    {
        return "https://replays.cnctdra.ea.com/". $this->cdnurl;
    }
    public function names(): array { return json_decode($this->names, false); }
    public function players(): array { return json_decode($this->players, false); }
    public function factions(): array { return json_decode($this->factions, false); }
    public function locations(): array { return json_decode($this->locations, false); }
    public function wasRandom(): array { return json_decode($this->wasrandom, false); }
    public function winningTeamId(): int { return $this->winningteamid; }
    public function matchDuration(): string { return date("H:i:s", $this->matchduration); }
    public function startTime(): string { return date("M d Y H:i:s", $this->starttime); }
    public function leaderboardHistoryId(): int { return $this->leaderboard_history_id; }
    public function extraPerPlayerSettings(): array { return json_decode($this->extraperplayersettings, false); }
    public function extraMatchSettings(): array { return json_decode($this->extramatchsettings, false); }
}