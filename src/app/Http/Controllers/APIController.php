<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPI;
use App\Http\Services\Steam\SteamAPI;
use App\Http\Services\SteamHelper;
use App\Http\Services\SteamWorkShopItem;
use App\Http\Services\Twitch\TwitchStreamsAPI;
use App\Leaderboard;
use App\Match;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    private $twitchStreamsAPI;
    private $steamAPI;
    private $petroglyphAPI;

    public function __construct()
    {
        $this->twitchStreamsAPI = new TwitchStreamsAPI();
        $this->steamAPI = new SteamAPI();
        $this->petroglyphAPI = new PetroglyphAPI();
    }

    public function tests()
    {
        set_time_limit(0);

        $limit = 200;
        $offset = 0;

        $response = $this->runNextRequest($limit, $offset);
        $totalMatchCount = $response["totalmatches"];
        
        $nextRequest = $this->saveRequest($response["matches"]);
        if ($nextRequest == false)
        {
            die("We have latest matches");
        }

        // Continue requests until we have nothing back from our matches array response
        $complete = false;
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
        

        // $leaderboardResult = $this->petroglyphAPI->getLeaderboard()["ranks"];
        // foreach($leaderboardResult as $result)
        // {
        //     Leaderboard::storeResult($result);
        // }
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

    public function runTask()
    {
        $this->twitchStreamsAPI->getToken();
    }

    public function streamCount()
    {
        $data = $this->twitchStreamsAPI->getStreamByGames(Constants::getTwitchGames());
        $counts = $this->twitchStreamsAPI->getCounts($data);

        return response($counts)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function totalStreamCount()
    {
        $data = $this->twitchStreamsAPI->getStreamByGames(Constants::getTwitchGames());
        $count = $this->twitchStreamsAPI->getCounts($data);
        
        $total = 0;
        foreach($count as $k => $arr)
        {
            $total += count($arr);
        }

        return response($total)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function streamByGameId($gameId, $limit = 100)
    {
        $data = $this->twitchStreamsAPI->getStreamByGame($gameId, $limit);

        return response($data)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function videosByGameId($gameId)
    {
        $data = $this->twitchStreamsAPI->getVideosByGame($gameId);

        return response($data)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }
}