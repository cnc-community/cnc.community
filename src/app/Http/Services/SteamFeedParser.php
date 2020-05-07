<?php

namespace App\Http\Services;

use App\NewsFeedQueue;
use Illuminate\Support\Facades\Http;

class SteamFeedParser extends AbstractFeedParser
{
    private $_feedUrl;
    private $_appId;
    private $_items;

    public function __construct($feedUrl, $appId)
    {
        $this->_feedUrl = $feedUrl;
        $this->_appId = $appId;
        $this->_items = [];
    }

    public function run()
    {
        $response = Http::get($this->_feedUrl . '?appid='. $this->_appId);

        foreach($response["appnews"]["newsitems"] as $k => $v) 
        {
            $this->_items[] = new SteamFeedItem($v);
        }

        foreach($this->_items as $steamFeedItem)
        {
            NewsFeedQueue::createFromNewsItem(
                $steamFeedItem->title(),
                $steamFeedItem->url(),
                $steamFeedItem->contents()
            );
        }
    }
}
