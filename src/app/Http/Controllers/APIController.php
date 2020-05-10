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
        $data = $this->twitchStreamsAPI->getStreamByGames(
            [
                "235", // Command & Conquer: Red Alert
                "10393", // Command & Conquer: Red Alert - Counterstrike
                "14999", // Command & Conquer: Red Alert - The Aftermath
                "4012", // Command & Conquer
                "1900", // Command & Conquer: Tiberian Sun
                "20015", // Command & Conquer: Tiberian Sun Firestorm
                "16580", // Command & Conquer: Red Alert 2
                "5090", // Command & Conquer: Yuri's Revenge
                "3813", // Command & Conquer: Renegade
                "18881", // Command & Conquer: Red Alert 3
                "18733", // Command & Conquer 3: Kane's Wrath
                "16106", // Command & Conquer 3: Tiberium Wars
                "10070", // Command & Conquer: Generals
                "16487", // Command & Conquer: Zero hour
            ]);
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