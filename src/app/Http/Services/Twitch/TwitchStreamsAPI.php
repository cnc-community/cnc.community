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

        return Cache::remember('getVideosByGame'.$gameId, 86400, function () use($gameId) // 1 day cache
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
        return Cache::remember('getStreamByGames'.$limit.$gameId, 300, function () use($gameId, $limit)
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
    
        return Cache::remember('getStreamByGames'.$queryString, 300, function () use($queryString)
        {
            $response = Http::withHeaders(
                [
                    "Client-ID" => $this->_clientId, 
                    "Authorization" => "Bearer " . $this->_token
                ])
                ->get($this->_apiUrl . TwitchStreamsAPI::STREAMS_URL . $queryString . '&first=100');

            return $response["data"];
        });
    }

    public function getCounts($data)
    {
        return Cache::remember('getCounts', 300, function () use($data)
        {
            $games = [];
            foreach($data as $twitchUser)
            {
                if (!in_array($twitchUser["user_name"], $games))
                {
                    $games[$twitchUser["game_id"]][]= $twitchUser["user_name"];
                }
            }
            return $games;
        });
    }
}
