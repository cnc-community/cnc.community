<?php

namespace App\Http\Services;

interface FeedHandlerInterface
{
    public function loadFeed();
}

class FeedServiceHandler implements FeedHandlerInterface
{
    private $_feed;

    public function __construct(AbstractCommunityFeed $feed)
    {
        $this->_feed = $feed;
    }

    public function loadFeed()
    {
        $this->_feed->run();
    }
}