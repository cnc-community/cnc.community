<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    public const APPROVED = "approved";
    public const DELETE = "delete";

    public const NEWS_INTERNAL = "internal";
    public const NEWS_EXTERNAL = "external";

    public function __construct()
    {
        
    }

    public function url()
    {
        if ($this->type == News::NEWS_EXTERNAL)
        {
            return $this->url;
        }
        
        return $this->category()->slug . "/" . $this->url;
    }

    public function category()
    {
        return Category::where("id", $this->category_id)->first();
    }

    public static function communityNewsPaginated()
    {
        $category = Category::where("name", "Community News")->first();
        return News::where("category_id", $category->id)->paginate(20);
    }

    public static function officialNewsPaginated()
    {
        $category = Category::where("name", "Official News")->first();
        return News::where("category_id", $category->id)->paginate(20);
    }

    public static function newsPaginatedByCategory($categoryId)
    {
        return News::where("category_id", $categoryId)->paginate(20);
    }

    public static function createNewsItem($title, $post, $url, $image, $categoryId)
    {
        $news = new News();
        $news->title = $title;
        if ($post)
        {
            $news->post = strip_tags($post, "<p><a>");
        }
        $news->type = News::NEWS_INTERNAL;
        $news->url = Str::of($title)->slug('-');
        if ($image)
        {
            $news->image = $image;
        }
        $news->category_id = $categoryId;
        $news->save();
        return $news;
    }

    public static function createFromQueuedItem($queuedItem): void
    {
        $news = new News();
        $news->title = $queuedItem->title;
        $news->type = News::NEWS_EXTERNAL;
        if ($queuedItem->post)
        {
            $news->post = strip_tags($queuedItem->post, "<p><a>");
        }
        $news->url = $queuedItem->url;
        $news->feed_uuid = $queuedItem->feed_uuid;
        $news->image = $queuedItem->image;
        $news->category_id = $queuedItem->category_id;
        $news->save();
    }
}
