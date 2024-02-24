<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\FeedHelper;
use App\News;

class NewsFeedQueue extends Model
{
    protected $connection = 'mysql';

    public const PENDING = "pending";
    public const APPROVED = "approved";
    public const REJECTED = "rejected";

    public function __construct()
    {
    }

    public static function count()
    {
        return NewsFeedQueue::all()->count();
    }

    public function category()
    {
        return Category::where("id", $this->category_id)->first();
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

    public static function createFromNewsItem($title, $url, $postHtml, $feedName): void
    {
        $uuid = NewsFeedQueue::createUuid($url);
        $exists = NewsFeedQueue::checkForDuplicateByUuid($uuid);
        $category = Category::where("name", "=", "Other")->first();
        $imageUrl = FeedHelper::getImageUrlFromString($postHtml);

        if ($exists == true)
        {
            return;
        }

        NewsFeedQueue::create($title, $url, $postHtml, $uuid, $category, $imageUrl, $feedName);
    }

    public static function createFromRedditItem($title, $url, $imageUrl): void
    {
        $uuid = NewsFeedQueue::createUuid($url);
        $exists = NewsFeedQueue::checkForDuplicateByUuid($uuid);
        $category = Category::where("name", "=", Category::CATEGORY_FUNNY)->first();

        if ($exists == true)
        {
            return;
        }

        $news = NewsFeedQueue::create($title, $url, null, $uuid, $category, $imageUrl, "Reddit");
        $news->approveQueuedItem();
    }

    private static function create($title, $url, $postHtml, $uuid, $category, $imageUrl, $feedName)
    {
        $newsQueue = new NewsFeedQueue();
        $newsQueue->title = html_entity_decode($title);
        $newsQueue->url = $url;
        $newsQueue->feed_uuid = $uuid;
        $newsQueue->feed_source = $feedName;
        $newsQueue->category_id = $category->id;

        if ($postHtml)
        {
            $newsQueue->post = strip_tags(html_entity_decode($postHtml), "<p><a>");
        }

        if ($imageUrl)
        {
            $newImageName = FeedHelper::createImageFromUrl($imageUrl);
            $newsQueue->image = $newImageName;
        }

        $newsQueue->save();

        return $newsQueue;
    }
}
