<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\FeedHelper;
use App\News;

class NewsFeedQueue extends Model
{
    public const PENDING = "pending";
    public const APPROVED = "approved";
    public const REJECTED = "rejected";

    public function __construct()
    {
    }

    
    /**
     * Rejects this queued item and removes it from being added
     */
    public function rejectQueuedItem(): void
    {
        NewsReject::rejectNews($this->feed_uuid, $this->url);
        $this->delete();
    }


    /**
     * Approves news item and publishes to the news table
     */
    public function approveQueuedItem(): void
    {
        News::createFromQueuedItem($this);
        $this->delete();
    }   


    /**
     * Create a UUID based on the news URL
     */
    public static function createUuid($url): string
    {
        return sha1($url);
    }


    /**
     * Check the uuid 
     */
    public static function checkForDuplicateByUuid($uuid): bool
    {
        // Check it doesn't already exist in our news queue
        $newsQueue = NewsFeedQueue::where("feed_uuid", $uuid)->first();
        if ($newsQueue != null) return true;

        // Check it doesn't already exist in our actual news
        $news = News::where("feed_uuid", $uuid)->first();
        if ($news != null) return true;

        // Check its in our rejected news table
        $reject = NewsReject::where("feed_uuid", $uuid)->first();
        if ($reject != null) return true;

        return false;
    }

    public static function createFromNewsItem($title, $url, $postHtml): void
    {
        $uuid = NewsFeedQueue::createUuid($url);
        $exists = NewsFeedQueue::checkForDuplicateByUuid($uuid);

        if ($exists == true)
        {
            return;
        }

        $newsQueue = new NewsFeedQueue();
        $newsQueue->title = $title;
        $newsQueue->post = strip_tags($postHtml, ["<p><a>"]);
        $newsQueue->url = $url;
        $newsQueue->feed_uuid = $uuid;

        $imageUrl = FeedHelper::getImageUrlFromString($postHtml);
        if ($imageUrl) 
        {
            $newImageName = FeedHelper::createImageFromUrl($imageUrl);
            $newsQueue->image = $newImageName;
        }
        
        $newsQueue->save();
    }
}
