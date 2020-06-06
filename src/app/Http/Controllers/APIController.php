<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Steam\SteamAPI;
use App\Http\Services\SteamHelper;
use App\Http\Services\SteamWorkShopItem;
use App\Http\Services\Twitch\TwitchStreamsAPI;
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
        return $this->twitchStreamsAPI->getCounts($data);
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
        return $total;
    }

    public function streamByGameId($gameId, $limit = 100)
    {
        return $this->twitchStreamsAPI->getStreamByGame($gameId, $limit);
    }

    public function videosByGameId($gameId)
    {
        return $this->twitchStreamsAPI->getVideosByGame($gameId);
    }
}