<?php

namespace App\Http\Services;

use Log;

abstract class AbstractFeedParser
{
    private $_feedParser;
    
    public function __construct($feedParser)
    {
        $this->_feedParser = $feedParser;
    }

    public function run()
    {
        try 
        {
            $this->_feedParser->run();
        }
        catch (\Exception $exception) 
        {
            Log::error($exception);
        }
    }
}
