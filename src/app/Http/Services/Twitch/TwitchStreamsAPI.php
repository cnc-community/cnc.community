<?php

namespace App\Http\Services\Twitch;

use App\Constants;
use Illuminate\Support\Facades\Http;
use App\Http\Services\Twitch\AbstractTwitchAPI;
use Illuminate\Support\Facades\Cache;

class TwitchStreamsAPI extends AbstractTwitchAPI
{
    public const STREAMS_URL = "streams";
    public const VIDEOS_URL = "videos";

    private $_apiUrl = "https://api.twitch.tv/helix/";
    private $_oauth2Url = "https://id.twitch.tv/oauth2/token";
    
    private $_clientId;
    private $_clientSecret;
    private $_token;

    public function __construct()
    {
        $this->_clientId = Constants::getTwitchClient();
        $this->_clientSecret = Constants::getTwitchSecret();
        $this->_token = $this->getToken();
    }

    public function getToken()
    {
        // 7 day cache of token
        return Cache::remember('twitchToken', 604800, function ()
        {
            $response = Http::post($this->_oauth2Url, [
                "client_id" => $this->_clientId, 
                "client_secret" => $this->_clientSecret,
                "grant_type" => "client_credentials"
            ]);

            return $response["access_token"];
        });
    }

    public function getVideosByGame($gameId)
    {   
        if (!in_array($gameId, Constants::getTwitchGames()))
        {
            return [];
        }

        // 30 minute cache
        return Cache::remember('getVideosByGame'.$gameId, 1800, function () use($gameId) 
        {
            $response = Http::withHeaders(
                [
                    "Client-ID" => $this->_clientId, 
                    "Authorization" => "Bearer " . $this->_token
                ])
                ->get($this->_apiUrl . TwitchStreamsAPI::VIDEOS_URL . '?game_id='. $gameId . '&first=3');

            return $response["data"];
        });
    }

    public function getStreamByGame($gameId, $limit)
    {   
        // 10 minute cache
        return Cache::remember('getStreamByGames'.$limit.$gameId, 600, function () use($gameId, $limit)
        {
            $response = Http::withHeaders(
                [
                    "Client-ID" => $this->_clientId, 
                    "Authorization" => "Bearer " . $this->_token
                ])
                ->get($this->_apiUrl . TwitchStreamsAPI::STREAMS_URL . '?game_id='. $gameId . '&first='.$limit);

            return $response["data"];
        });
    }

    public function getStreamByGames($games)
    {
        $queryString = "";

        $i = 0;
        foreach($games as $k => $game)
        {
            if ($i == 0){
                $queryString .= "?game_id=" . $game;
            }
            $queryString .= "&game_id=" . $game;
            $i++;
        }

        $data = [];
        
        // 10 minute cache
        return Cache::remember('getStreamByGames'.$queryString, 600, function () use($queryString, $data)
        {
            $count = 0;
            $pagination = "";
            $json = $this->fetchByQuery($queryString, $pagination);

            while($json["pagination"] != null)
            {
                $json = $this->fetchByQuery($queryString, $json["pagination"]["cursor"]);
                $count++;

                foreach($json["data"] as $r)
                {
                    $data[] = $r;
                }
                
                // safety
                if ($count > 10)
                {
                    die("Safety kill");
                }
            }
            return $data;
        });
    }

    private function fetchByQuery($queryString, $pagination = "")
    {
        return Http::withHeaders(
            [
                "Client-ID" => $this->_clientId, 
                "Authorization" => "Bearer " . $this->_token
            ])
            ->get($this->_apiUrl . TwitchStreamsAPI::STREAMS_URL . $queryString . '&first=100&after='.$pagination)
            ->json();
    }

    public function getCounts($data)
    {
        $games = [];
        
        // 10 minute cache
        return Cache::remember('getCounts', 600, function () use($data, $games)
        {
            foreach($data as $twitchUser)
            {
                // Late night thoughts why this is even needed
                // Leaving incase it might be needed again :-o
                // if (!in_array($twitchUser["user_name"], $games))
                // {
                // }
                $games[$twitchUser["game_id"]][]= $twitchUser["user_name"];
            }
            return $games;
        });
    }
}
