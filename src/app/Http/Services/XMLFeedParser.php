<?php

namespace App\Http\Services;

use App\NewsFeedQueue;
use Log;

class XMLFeedParser extends AbstractFeedParser
{
    private $_feedUrl;
    private $_feedName;

    public function __construct($feedUrl, $feedName)
    {
        $this->_feedUrl = $feedUrl;
        $this->_feedName = $feedName;
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
                        $newsItem->description,
                        $this->_feedName
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
