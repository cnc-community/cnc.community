<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsReject extends Model
{
    protected $connection= 'mysql';

    public static function rejectNews($uuid, $url)
    {
        $reject = new NewsReject();
        $reject->feed_uuid = $uuid;
        $reject->url = $url;
        $reject->save();
    }
}
