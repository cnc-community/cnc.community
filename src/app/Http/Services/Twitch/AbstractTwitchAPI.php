<?php

namespace App\Http\Services\Twitch;

abstract class AbstractTwitchAPI
{
    private $_parser;
    
    public function __construct($parser)
    {
        $this->_parser = $parser;
    }

    public function getStreamByGame($gameId, $limit)
    {
        $this->_parser->getStreamByGame($gameId, $limit);
    }

    public function getStreamByGames($games)
    {
        $this->_parser->getStreamByGames($games);
    }
}
