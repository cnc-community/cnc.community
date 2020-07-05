<?php

namespace App\Http\Services\Petroglyph;

use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Leaderboard;
use App\LeaderboardMatchHistory;
use App\Match;
use App\MatchPlayer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PetroglyphAPIService
{
    private $petroglyphAPI;

    public function __construct()
    {
        $this->petroglyphAPI = new PetroglyphAPI();
    }
       
    public function runMatchesTask()
    {
        $this->getMatchesTask();
    }

    public function runRALeaderboardTasks()
    {
        $leaderboard = Leaderboard::where("type", "ra_1vs1")->first();
        $history = $leaderboard->history();

        $this->getRALeaderboard($history, 200, 0);
        $this->getRALeaderboard($history, 200, 200);
        $this->getRALeaderboard($history, 200, 400);
        $this->getRALeaderboard($history, 200, 600);
        $this->getRALeaderboard($history, 200, 800);
    }

    private function getRALeaderboard($history, $limit, $offset)
    {
        sleep(6);

        $leaderboardResult = $this->petroglyphAPI->getRALeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveData($history->id, $result);
        }
    }

    public function runTDLeaderboardTasks()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        $history = $leaderboard->history();

        $this->getTDLeaderboard($history, 200, 0);
        $this->getTDLeaderboard($history, 200, 200);
        $this->getTDLeaderboard($history, 200, 400);
        $this->getTDLeaderboard($history, 200, 600);
        $this->getTDLeaderboard($history, 200, 800);
    }

    private function getTDLeaderboard($history, $limit, $offset)
    {
        sleep(6);

        $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveData($history->id, $result);
        }
    }

    private function getMatchesTask()
    {
        set_time_limit(0);

        $limit = 200;
        $offset = 0;
        $complete = false;

        $response = $this->sendGetMatches($limit, $offset);
        $totalMatchCount = $response["totalmatches"];
        
        $nextRequest = $this->saveMatchResponse($response["matches"]);
        if ($nextRequest == false)
        {
            $complete = true;
        }

        // Continue requests until we have nothing back from our matches array response
        while(count($response["matches"]) > 0 && $complete == false)
        {
            // Timeout between requests
            sleep(8);

            // For our next request
            $offset += $limit;
            
            $response = $this->sendGetMatches($limit, $offset);
            $nextRequest = $this->saveMatchResponse($response["matches"]);

            if ($nextRequest == false)
            {
                $complete = true;
                break;
            }

            if ($offset > $totalMatchCount)
            {
                // Safety - somethings gone wrong here
                Log::debug("Error - Offset was more than total matches");
                die("Safety kill switch");
            }
        }
    }

    private function sendGetMatches($limit, $offset)
    {
        return $this->petroglyphAPI->getMatches($limit, $offset);
    }

    private function saveMatchResponse($matches)
    {
        $matchIds = [];
        foreach($matches as $matchResponse)
        {
            $matchIds[] = $matchResponse["matchid"];
        }

        // Find the ones that exist
        $newMatches = Match::whereIntegerInRaw("matchid", $matchIds)->get()->toArray();
        
        $existingMatchIds = [];
        foreach($newMatches as $match)
        {
            $existingMatchIds[] = $match["matchid"];
        }

        // Compare with with all match ids and get the ones we want to insert
        $idsToInsert = array_merge(array_diff($matchIds, $existingMatchIds));

        // Otherwise sync new matches
        foreach($matches as $matchResponse)
        {
            if (in_array($matchResponse["matchid"], $idsToInsert))
            {
                Match::createMatch($matchResponse);
                Match::savePlayersFromMatch($matchResponse);
            }
        }

        // Nothing more to do
        if (count($idsToInsert) == 0)
        {
            return false;
        }

        return true;
    }
}