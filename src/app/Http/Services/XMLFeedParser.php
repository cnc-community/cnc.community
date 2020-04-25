<?php

namespace App\Http\Services;

use App\NewsFeedQueue;
use Log;

class XMLFeedParser extends AbstractFeedParser
{
    private $_feedUrl;

    public function __construct($feedUrl)
    {
        $this->_feedUrl = $feedUrl;
    }

    public function run()
    {
        try {
            $xml = simplexml_load_file($this->_feedUrl) or die("Failed to load");

            // <author>
            // <title>
            // <category>
            // <link>
            // <description>
            // <pubDate>

            foreach ($xml->channel->children() as $newsItem) 
            {
                if ($newsItem == null) 
                {
                    continue;
                }

                if (strlen($newsItem->title) > 0) 
                {
                    NewsFeedQueue::createFromNewsItem(
                        $newsItem->title, 
                        $newsItem->link, 
                        $newsItem->description
                    );
                }
            }
        }
        catch (\Exception $exception) 
        {
            Log::error($exception);
        }
    }
}
