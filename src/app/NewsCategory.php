<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';

    public static function addRemoveCategory($newsId, $categories)
    {
        NewsCategory::where("news_id", $newsId)->delete();

        foreach($categories as $categoryId)
        {
            $cat = new NewsCategory();
            $cat->news_id = $newsId;
            $cat->category_id = $categoryId;
            $cat->save();
        }
    }
}
