<?php 

namespace App\Http\Controllers;

use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Leaderboard;
use App\LeaderboardHistory;
use App\Match;

class LeaderboardController extends Controller
{
    private $petroglyphAPI;

    public function __construct()
    {
        $this->petroglyphAPI = new PetroglyphAPI();
    }

    public function getTopRALeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "ra_1vs1")->first();
        return $leaderboard->data();
    }

    public function getTopTDLeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        return $leaderboard->history();
    }
    
    public function runTasks()
    {
        set_time_limit(0);

        $limit = 200;
        $offset = 0;
        $complete = false;

        $response = $this->runNextRequest($limit, $offset);
        $totalMatchCount = $response["totalmatches"];
        
        $nextRequest = $this->saveRequest($response["matches"]);
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
            
            $response = $this->runNextRequest($limit, $offset);
            $nextRequest = $this->saveRequest($response["matches"]);

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
        }
        
        $leaderboardResult = $this->petroglyphAPI->getRALeaderboard(200, 0)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveRA1vs1Data($result);
        }

        $leaderboardResult = $this->petroglyphAPI->getTDLeaderboard(200, 0)["ranks"];
        foreach($leaderboardResult as $result)
        {
            Leaderboard::saveTDvs1Data($result);
        }
    }

    private function runNextRequest($limit, $offset)
    {
        return $this->petroglyphAPI->getMatches($limit, $offset);
    }

    private function saveRequest($matches)
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