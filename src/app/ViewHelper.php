<?php

namespace App;

use App\PageCustomField;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ViewHelper
{
    public static function createPaginationFromArray($arr, $perPage, $currentPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($arr);
        $currentPageResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        return new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
    }

    public static function getCustomFieldContents($pageId, $key)
    {
        $customField = PageCustomField::getCustomFieldByPageAndKey($pageId, $key);
        if ($customField)
        {
            return $customField->getContent();
        }
        return null;
    }

    public static function getCategoryCustomFieldContents($categoryId, $key)
    {
        $customField = PageCustomField::getCustomFieldsByPageCategoryIdAndKey($categoryId, $key);
        if ($customField)
        {
            return $customField->getContent();
        }
        return null;
    }

    public static function getGameLogoPathByName($slug)
    {
        return "/assets/images/logos/" . $slug . "-logo.png";
    }
    
    public static function getFeatureBannerByGameSlug($slug)
    {
        return "/assets/images/banners/". $slug . ".jpg";
    }

    public static function renderSpecialOctal($string)
    {
        return preg_replace_callback('/\\\\([0-7]{1,3})/', function($octal)
        { 
            return chr(octdec($octal[1]));
        }, $string);
    }
}