<?php

namespace App\Http\Services\Steam;

abstract class AbstractSteamAPI
{
    private $_parser;
    
    public function __construct($parser)
    {
        $this->_parser = $parser;
    }

    public function getWorkshopItemsByAppId($appId)
    {
        $this->_parser->getWorkshopItemsByGameId($appId);
    }
}
