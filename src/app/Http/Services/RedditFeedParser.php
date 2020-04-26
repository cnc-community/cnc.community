<?php

namespace App\Http\Services;

use App\NewsFeedQueue;

class RedditFeedParser extends AbstractFeedParser
{
    private $_feedUrl;

    public function __construct($feedUrl)
    {
        $this->_feedUrl = $feedUrl;
    }

    public function run()
    {
        $json = file_get_contents($this->_feedUrl);
        $json = json_decode($json);

        foreach($json->data->children as $k => $v)
        {
            $this->_items[] = new RedditFeedItem($v);
        }

        foreach($this->_items as $redditFeedItem)
        {
            if ($redditFeedItem->score() >= 300)
            {
                if ($redditFeedItem->postType() == RedditFeedItem::POST_HINT_IMAGE)
                {
                    NewsFeedQueue::createFromRedditItem(
                        $redditFeedItem->title(), 
                        "https://www.reddit.com/". $redditFeedItem->permalink(), 
                        $redditFeedItem->url()
                    );
                }
            }
        }
    }
}
