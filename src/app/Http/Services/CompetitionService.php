<?php

namespace App\Http\Services;

use App\Match;

class CompetitionService
{
    public function __construct()
    {
    }

    public function getPlayersByMatchType($matchType)
    {
        $matches = Match::where("matchtype", $matchType)
            ->orderBy("starttime", "DESC")
            ->select(["names", "players", "matchtype"])
            ->limit(400)
            ->get();

        $playerList = [];

        foreach($matches as $match)
        {
            $players = json_decode($match->players);

            foreach($players as $key => $playerId)
            {
                $names = json_decode($match->names);
                $playerName = $names[$key];

                $playerList[$playerId][] = $playerName;
            }
        }
        return $this->formatResultsWithKeys($playerList);
    }

    private function formatResultsWithKeys($results)
    {
        $count = 0;
        $keyedResults = [];
        foreach($results as $k => $v)
        {
            $keyedResults[$count][$k] = $v;
            $count++;
        }
        return $keyedResults;
    }
}