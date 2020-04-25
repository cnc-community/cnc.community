<?php

namespace App\Http\Services;

abstract class AbstractCommunityFeed
{
    private $_feedParser;
    
    public function __construct($feedParser)
    {
        $this->_feedParser = $feedParser;
    }

    public function run()
    {
        $this->_feedParser->run();
    }
}
