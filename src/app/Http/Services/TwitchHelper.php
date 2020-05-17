<?php 

namespace App\Http\Services;

use App\Constants;
use App\Http\Services\Twitch\TwitchStreamsAPI;

class TwitchHelper
{
    private $twitchStreamsAPI;

    public function __construct()
    {
        $this->twitchStreamsAPI = new TwitchStreamsAPI();
    }

    public function getTwitchGamesBySlug($slug)
    {
        $gameId = $this->getGameIdBySlug($slug);
        return $this->twitchStreamsAPI->getStreamByGame($gameId);
    }

    public function getTwitchVideosBySlug($slug)
    {
        $gameId = $this->getGameIdBySlug($slug);
        return $this->twitchStreamsAPI->getVideosByGame($gameId);
    }

    private function getGameIdBySlug($slug)
    {
        $games = Constants::getTwitchGames();
        $gameId = -1;

        foreach($games as $key => $value)
        {
            if ($key == $slug)
            {
                $gameId = $value;
            }
        }
        return $gameId;
    }

    public static function getTwitchThumbnailUrl($url, $width, $height)
    {
        return str_replace(
            array("{width}","{height}", "%"),
            array($width, $height, ""),
            $url
        );
    }
}