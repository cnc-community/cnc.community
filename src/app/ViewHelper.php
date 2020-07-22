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

    public static function getRARemasterLogo()
    {
        return "/assets/images/logos/red-alert-remastered.png";
    }

    public static function getTDRemasterLogo()
    {
        return "/assets/images/logos/tiberian-dawn-remastered.png";
    }

    public static function getRemasterLogoBySlug($slug)
    {
        switch($slug)
        {
            case "red-alert":
                return ViewHelper::getRARemasterLogo();

            case "tiberian-dawn":
                return ViewHelper::getTDRemasterLogo();
        }
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

    public static function paginate($items, $perPage = 15, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ];

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public static function getLeaderboardRanksByPageNumber($pageNumber)
    {
        switch($pageNumber)
        {
            case 5:
                return [1000];

            case 4:
            case 3:
                return [600];

            case 2:
                return [400];
            
            case 1:
            default:
                return [16, 200];
        }

        return [];
    }
}