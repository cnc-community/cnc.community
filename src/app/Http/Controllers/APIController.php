<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Steam\SteamAPI;
use App\Http\Services\SteamHelper;
use App\Http\Services\SteamWorkShopItem;
use App\Http\Services\Twitch\TwitchStreamsAPI;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

class APIController extends Controller
{
    private $twitchStreamsAPI;
    private $steamAPI;

    public function __construct()
    {
        $this->twitchStreamsAPI = new TwitchStreamsAPI();
        $this->steamAPI = new SteamAPI();
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