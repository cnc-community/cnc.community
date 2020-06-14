<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';

    public static function addCategory($newsId, $categoryId)
    {
        $newsCategory = NewsCategory::where("news_id", "=", $newsId)
            ->where("category_id", "=", $categoryId)
            ->first();

        if ($newsCategory == null)
        {
            $newsCategory = new NewsCategory();
            $newsCategory->news_id = $newsId;
            $newsCategory->category_id = $categoryId;
            $newsCategory->save();
        }

        return $newsCategory;
    }

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
