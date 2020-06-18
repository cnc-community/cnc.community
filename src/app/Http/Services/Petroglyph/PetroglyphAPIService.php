<?php

namespace App\Http\Services\Petroglyph;

use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Leaderboard;
use App\Match;

class PetroglyphAPIService
{
    private $petroglyphAPI;

    public function __construct()
    {
        $this->petroglyphAPI = new PetroglyphAPI();
    }
       
    public function runTasks()
    {
        $this->getMatchesTask();
        $this->getLeaderboardTask();
    }

    private function getLeaderboardTask()
    {
        $this->getRALeaderboard(200, 0);
        $this->getRALeaderboard(200, 200);
        $this->getRALeaderboard(200, 400);

        $this->getTDLeaderboard(200, 0);
        $this->getTDLeaderboard(200, 200);
        $this->getTDLeaderboard(200, 400);
    }

    private function getRALeaderboard($limit, $offset)
    {
        sleep(5);

        $leaderboardResult = $this->petroglyphAPI->getRALeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveRA1vs1Data($result);
        }
    }

    private function getTDLeaderboard($limit, $offset)
    {
        sleep(5);

        $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveTDvs1Data($result);
        }
    }

    private function getMatchesTask()
    {
        set_time_limit(0);

        $limit = 200;
        $offset = 0;
        $complete = false;
        $debug = false;

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
            sleep(4);

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
                die("Safety kill switch");
            }
            
            if ($debug == true)
            {
                // Run once
                $complete = true;
            }
        }
    }

    private function sendGetMatches($limit, $offset)
    {
        return $this->petroglyphAPI->getMatches($limit, $offset);
    }

    private function saveMatchResponse($matches)
    {
        $nextRequest = true;

        // We get the results and go over them
        foreach($matches as $matchResponse)
        {
            $matchExists = Match::checkMatchExists($matchResponse["matchid"]);
            if ($matchExists == null)
            {
                $nextRequest = true;

                // Otherwise create a match record
                Match::createMatch($matchResponse);
                
                // Update any new players
                Match::savePlayersFromMatch($matchResponse);
            }
            else
            {
                // If we know a match exists, blindly assume we're up to date and stop any further requests
                $nextRequest = false;
                break;
            }
        }
        return $nextRequest;
    }
}
