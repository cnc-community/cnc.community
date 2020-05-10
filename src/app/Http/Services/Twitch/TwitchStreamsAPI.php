<?php

namespace App\Http\Services\Twitch;

use Illuminate\Support\Facades\Http;
use App\Http\Services\Twitch\AbstractTwitchAPI;
Use Illuminate\Support\Facades\Cache;

class TwitchStreamsAPI extends AbstractTwitchAPI
{
    public const STREAMS_URL = "streams";
    public const VIDEOS_URL = "videos";

    private $_apiUrl = "https://api.twitch.tv/helix/";
    private $_clientId;

    public function __construct($clientId)
    {
        $this->_clientId = $clientId;
    }

    public function getVideosByGame($gameId)
    {   
        return Cache::remember('getVideosByGame'.$gameId, 86400, function () use($gameId) // 1 day cache
        {
            $response = Http::withHeaders(["Client-ID" => $this->_clientId])
                ->get($this->_apiUrl . TwitchStreamsAPI::VIDEOS_URL . '?game_id='. $gameId . '&first=3');

            return $response["data"];
        });
    }


    public function getStreamByGame($gameId)
    {   
        return Cache::remember('getStreamByGames'.$gameId, 300, function () use($gameId)
        {
            $response = Http::withHeaders(["Client-ID" => $this->_clientId])
                ->get($this->_apiUrl . TwitchStreamsAPI::STREAMS_URL . '?game_id='. $gameId . '&first=100');

            return $response["data"];
        });
    }

    public function getStreamByGames($games)
    {
        $queryString = "";

        foreach($games as $k => $game)
        {
            if ($k == 0){
                $queryString .= "?game_id=" . $game;
            }
            $queryString .= "&game_id=" . $game;
        }

        return Cache::remember('getStreamByGames'.$queryString, 300, function () use($queryString)
        {
            $response = Http::withHeaders(["Client-ID" => $this->_clientId])
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
