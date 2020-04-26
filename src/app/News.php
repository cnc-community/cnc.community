<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsReject;

class News extends Model
{
    public const APPROVED = "approved";
    public const DELETE = "delete";

    public function __construct()
    {
        
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

    public static function createFromQueuedItem($queuedItem): void
    {
        $news = new News();
        $news->title = $queuedItem->title;
        $news->post = strip_tags($queuedItem->post, ["<p><a>"]);
        $news->url = $queuedItem->url;
        $news->feed_uuid = $queuedItem->feed_uuid;
        $news->image = $queuedItem->image;
        $news->category_id = $queuedItem->category_id;
        $news->save();
    }
}
