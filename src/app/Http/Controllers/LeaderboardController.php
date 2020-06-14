<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Leaderboard;
use App\LeaderboardHistory;
use App\Match;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    private $petroglyphAPI;

    public function __construct()
    {
        $this->petroglyphAPI = new PetroglyphAPI();
    }

    public function getLeaderboardListings()
    {
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        
        return view('pages.remasters.leaderboard.listings', 
            [
                "heroVideo" => $heroVideo
            ]
        );
    }

    public function getLeaderboardListingsByGame(Request $request, $game)
    {
        $gameName = "";
        $gameLogo = "";
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        $data = [];

        switch($game)
        {
            case "tiberian-dawn":
                $leaderboardTD = Leaderboard::where("type", "td_1vs1")->first();
                $top15Data = $leaderboardTD->data(15,0);
                $data = $leaderboardTD->dataPaginated(50, 200);
                $gameName = "Tiberian Dawn";
                $gameLogo = "/assets/images/logos/tiberian-dawn-remastered.png";
                break;

            case "red-alert":
                $leaderboardRA = Leaderboard::where("type", "ra_1vs1")->first();
                $data = $leaderboardRA->dataPaginated(50, 200);
                $top15Data = $leaderboardRA->data(15,0);
                $gameName = "Red Alert";
                $gameLogo = "/assets/images/logos/red-alert-remastered.png";

                break;

            default: 
                abort(404);
        }

        $pageNumber = $request->page == null ? 0: $request->page;
        return view('pages.remasters.leaderboard.detail', 
            [
                "top15Data" => $top15Data,
                "data" => $data,
                "gameLogo" => $gameLogo,
                "gameName" => $gameName,
                "heroVideo" => $heroVideo,
                "gameSlug" => $game,
                "pageNumber" => $pageNumber
            ]
        );
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