<?php

namespace App\Http\Sites;

use App\Http\Services\AbstractCommunityFeed;

class DTAFeed extends AbstractCommunityFeed
{
    private $_parser;

    public function __construct($parser)
    {
        $this->_parser = $parser;
    }

    public function run()
    {
        $this->_parser->run();
    }
}
