<?php

namespace App\Http\Services\Petroglyph;

use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Leaderboard;
use App\LeaderboardHelper;
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

    // Sync enough for local development
    // Syncing everything would take a LONG time.
    public function runMatchTaskWithLimit($limitTimesRun = 2)
    {
        $this->getMatchesTask($limitTimesRun);
    }
       
    public function runMatchesTask()
    {
        $this->getMatchesTask();
    }

    public function runRALeaderboardTasks($canSleep = true)
    {
        $history = Leaderboard::getActiveLeaderboardSeason(Match::RA_1vs1);
        if ($history == null)
        {
            die();
        }   

        $this->getRALeaderboard($history, 200, 0, $canSleep);
        $this->getRALeaderboard($history, 200, 200, $canSleep);
        $this->getRALeaderboard($history, 200, 400, $canSleep);
    }

    public function getRALeaderboard($history, $limit, $offset, $canSleep = true)
    {
        if($canSleep)
        {
            sleep(100);
        }

        $leaderboardResult = $this->petroglyphAPI->getRALeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveData($history->id, $result);
        }
    }

    public function runTDLeaderboardTasks($canSleep = true)
    {
        $history = Leaderboard::getActiveLeaderboardSeason(Match::TD_1vs1);
        if ($history == null)
        {
            die();
        }   

        $this->getTDLeaderboard($history, 200, 0, $canSleep);
        $this->getTDLeaderboard($history, 200, 200, $canSleep);
        $this->getTDLeaderboard($history, 200, 400, $canSleep);
    }

    public function getTDLeaderboard($history, $limit, $offset,$canSleep = true)
    {
        if($canSleep)
        {
            sleep(100);
        }

        $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard($limit, $offset)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveData($history->id, $result);
        }
    }

    private function getMatchesTask($localDevelopment = true)
    {
        set_time_limit(0);

        $limit = 200;
        $offset = 0;
        $complete = false;
        $timesRun = 0;

        $response = $this->sendGetMatches($limit, $offset);
        $totalMatchCount = $response["totalmatches"];
        
        $nextRequest = $this->saveMatchResponse($response["matches"]);
        if ($nextRequest == false)
        {
            $complete = true;
        }

        // @TODO: Suspect this is causing the high memory usage
        // Continue requests until we have nothing back from our matches array response
        /*
        while(count($response["matches"]) > 0 && $complete == false)
        {
            // Timeout between requests
            sleep(8);

            // For our next request
            $offset += $limit;
            
            $response = $this->sendGetMatches($limit, $offset);
            $nextRequest = $this->saveMatchResponse($response["matches"]);


            // Stop syncing as its only local development
            if ($localDevelopment && $timesRun > 3)
            {
                $complete = true;
                break;
            }
            
            // Stop syncing when we've fetched everything
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

            $timesRun++;
        }
        */
    }

    private function sendGetMatches($limit, $offset)
    {
        return $this->petroglyphAPI->getMatches($limit, $offset);
    }

    private function saveMatchResponse($matches)
    {
        $historyRA = Leaderboard::getActiveLeaderboardSeason(Match::RA_1vs1);
        if ($historyRA == null)
        {
            die();
        }   
        
        $historyTD = Leaderboard::getActiveLeaderboardSeason(Match::TD_1vs1);
        if ($historyTD == null)
        {
            die();
        }   

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
                $match = Match::createMatch($matchResponse);
                if ($match->matchtype == Match::RA_1vs1)
                {
                    $match->leaderboard_history_id = $historyRA->id;
                    $match->save();
                }
                else if ($match->matchtype == Match::TD_1vs1)
                {
                    $match->leaderboard_history_id = $historyTD->id;
                    $match->save();
                }

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