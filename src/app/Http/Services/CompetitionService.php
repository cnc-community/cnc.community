<?php

namespace App\Http\Services;

use App\Match;

class CompetitionService
{
    public function __construct()
    {
    }

    public function getPlayersByMatchType($matchType, $timeStart, $timeEnd)
    {
        return $this->getLast24Hours($matchType, $timeStart, $timeEnd);
        // $matches = Match::where("matchtype", $matchType)
        //     ->orderBy("starttime", "DESC")
        //     ->select(["names", "players", "matchtype"])
        //     ->limit(200)
        //     ->get();

        // return $matches;

        // $playerList = [];

        // foreach($matches as $match)
        // {
        //     $players = json_decode($match->players);

        //     foreach($players as $key => $playerId)
        //     {
        //         $names = json_decode($match->names);
        //         $playerName = $names[$key];

        //         $playerList[$playerId][] = $playerName;
        //     }
        // }
        // return $this->formatResultsWithKeys($playerList);
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

    private function getLast24Hours($matchType, $timeStart, $timeEnd)
    {
        // Uncomment when we're on Friday 6pm BST
        // $last24Hours = time() - (24 * 60 * 60);

        // 24th 6pm BST 1600966800
        return Match::where("matchtype", $matchType)
            ->where('starttime', '>=', $timeStart)
            ->where('starttime', '<=', $timeEnd)
            ->orderBy("starttime", "DESC")
            ->paginate(200);
    }
}