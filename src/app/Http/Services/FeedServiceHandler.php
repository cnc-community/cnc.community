<?php

interface iFeed
{
    public function loadFeed();
}

class FeedServiceHandler implements iFeed
{
    public function __construct($feed)
    {

    }
}

