<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\NewsReject;

class News extends Model
{
    public static function createFromQueuedItem($queuedItem): void
    {
        $news = new News();
        $news->title = $queuedItem->title;
        $news->post = strip_tags($queuedItem->post, ["<p><a>"]);
        $news->url = $queuedItem->url;
        $news->feed_uuid = $queuedItem->feed_uuid;
        $news->image = $queuedItem->image;
        $news->save();
    }
}
