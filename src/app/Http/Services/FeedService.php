<?php

interface iFeed
{
    public function loadFeed();
}

class FeedService implements iFeed
{
    public function __construct()
    {
        
    }
}

?>