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
        // $this->getMatchesTask();
        $this->getLeaderboardTask();
    }

    // TODO - handle properly but for now it works and does the job
    private function getLeaderboardTask()
    {
        // Ra
        $leaderboardResult = $this->petroglyphAPI->getRALeaderboard(200, 0)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveRA1vs1Data($result);
        }

        sleep(5);

        // $leaderboardResult = $this->petroglyphAPI->getRALeaderboard(200, 200)["ranks"];
        // foreach($leaderboardResult as $result)
        // {
        //     Leaderboard::saveRA1vs1Data($result);
        // }

        // sleep(5);

        // // TD
        // $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard(200, 0)["ranks"];
        // foreach($leaderboardResult as $result)
        // {
        //     Leaderboard::saveTDvs1Data($result);
        // }

        // sleep(5);
        
        // $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard(200, 200)["ranks"];
        // foreach($leaderboardResult as $result)
        // {
        //     Leaderboard::saveTDvs1Data($result);
        // }
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
