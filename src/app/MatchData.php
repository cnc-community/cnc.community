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

    /*
    Just dumping here for now ignore
    ```
    enum FactionType
    {
        FT_INVALID = -1,                    //:const text("Invalid")
        FT_FACTION_1 = 0,                    //:const text("Faction1")  // Tiberian Dawn GDI
        FT_FACTION_2,                        //:const text("Faction2")  // Tiberian Dawn NOD
        FT_FACTION_3,                        //:const text("Faction3")    // Red Alert Spain 
        FT_FACTION_4,                        //:const text("Faction4")    // Red Alert Greece
        FT_FACTION_5,                        //:const text("Faction5")    // Red Alert USSR
        FT_FACTION_6,                        //:const text("Faction6")    // Red Alert England
        FT_FACTION_7,                        //:const text("Faction7")    // Red Alert Ukraine
        FT_FACTION_8,                        //:const text("Faction8")    // Red Alert Germany
        FT_FACTION_9,                        //:const text("Faction9")    // Red Alert France
        FT_FACTION_10,                        //:const text("Faction10")    // Red Alert Turkey
        FT_FACTION_11,                        //:const text("Faction11") // Tiberian Dawn Jurassic Funpark 
        FT_FACTION_LAST = FT_FACTION_11,
        FT_RANDOM = 42,                    //:const text("Random")
        FT_REPLAY,                            //:const text("Replay")
        FT_DUMMY,                            //:const text("Dummy")
        FT_UNSPECIFIED                        //:const text("Unspecified")
    };
    [11:12 PM]
    So GDI=0, NOD=1, spain=2, ....
    ```
    */
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