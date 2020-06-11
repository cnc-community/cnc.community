<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\User;

class News extends Model
{
    public const APPROVED = "approved";
    public const DELETE = "delete";

    public const NEWS_INTERNAL = "internal";
    public const NEWS_EXTERNAL = "external";

    public function __construct()
    {
    }

    public function readTime()
    {
        // https://gist.github.com/mynameispj/3170442
        $word = str_word_count(strip_tags($this->post));
        $m = floor($word / 200);
        $s = floor($word % 200 / (200 / 60));
        $est = $m . ' minute';
        return $est;
    }

    public function author()
    {
        $user = User::where("id", $this->user_id)->select("name")->first();
        if ($user)
        {
            return $user;
        }
        return null;
    }

    public function excerpt()
    {
        return Str::limit(strip_tags($this->post, "<p>"), 450);
    }

    public function url()
    {
        if ($this->type == News::NEWS_EXTERNAL)
        {
            return $this->url;
        }
        
        return "/news/" . $this->primaryCategory()->slug . "/" . $this->url;
    }

    public function hasCategory($categoryId)
    {
        return NewsCategory::where("news_id", $this->id)->where("category_id", $categoryId)->first();
    }

    public static function categoriesExcludingPrimary($primaryId)
    {
        return Category::where("id", "!=", $primaryId)->get();
    }

    public function categories()
    {
        return Category::leftJoin("news_categories", "categories.id", "=", "news_categories.category_id")
            ->where("news_categories.news_id", "=", $this->id)
            ->get();
    }

    public function primaryCategory()
    {
        return Category::find($this->category_id);
    }

    public static function newsByCategoryId($categoryId, $limit = 20)
    {
        $category = Category::where("id", $categoryId)->first();
        if ($category == null)
        {
            return [];
        }

        return NewsCategory::leftJoin("news", "news_categories.news_id", "=", "news.id")
            ->where("news_categories.category_id", "=", $categoryId)
            ->select("news.*")
            ->orderByDesc("news.created_at")
            ->paginate($limit);
    }

    public static function officialNewsPaginated($limit = 20)
    {
        $primaryCategory = Category::where("name", "Official News")->first();

        return NewsCategory::leftJoin("news", "news_categories.news_id", "=", "news.id")
            ->where("news_categories.category_id", "=", $primaryCategory->id)
            ->select("news.*")
            ->orderByDesc("news.created_at")
            ->paginate($limit);
    }

    public static function newsPaginatedByCategory($categoryId, $limit = 20)
    {
        return NewsCategory::leftJoin("news", "news_categories.news_id", "=", "news.id")
            ->where("news_categories.category_id", "=", $categoryId)
            ->select("news.*")
            ->orderByDesc("news.created_at")
            ->paginate($limit);
    }

    public static function createNewsItem($title, $post, $url, $image, $categoryId, $userId)
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
        $news->user_id = $userId;
        $news->save();

        NewsCategory::addCategory($news->id, $news->category_id);
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

        NewsCategory::addCategory($news->id, $news->category_id);
    }
}
