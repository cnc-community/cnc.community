<?php 

namespace App\Http\Controllers;

use App\Http\Services\Twitch\TwitchStreamsAPI;

class APIController extends Controller
{
    private $twitchStreamsAPI;

    public function __construct()
    {
        $this->twitchStreamsAPI = new TwitchStreamsAPI("cds8o89o71q4a4us2desr58fo3tyizd");
    }

    public function streamCount()
    {
        $data = $this->twitchStreamsAPI->getStreamByGames(["235","10393","14999","1421","4012","1900","20015","16580","5090","3813"]);
        $count = $this->twitchStreamsAPI->getCounts($data);
        return $count;
    }

    public function streamByGameId($gameId)
    {
        return $this->twitchStreamsAPI->getStreamByGame($gameId);
    }

    public function streamByGames()
    {
        return $this->twitchStreamsAPI->getStreamByGames(["235","10393","14999","1421","4012","1900","20015","16580","5090","3813"]);
    }
}