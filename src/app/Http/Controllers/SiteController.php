<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Sites\PPMFeed;
use App\Http\Sites\DTAFeed;
use App\Http\Services\XMLFeedParser;
use App\News;
use App\Page;
use App\Constants;
use App\Http\Services\TwitchHelper;
use App\PageCategory;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    private $twitchHelper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->twitchHelper = new TwitchHelper();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $key = "cache_";

        $officialNewsCache = Cache::remember($key."home.index.officialNews", Constants::getCacheSeconds(), function () 
        {
            return News::officialNewsPaginated();
        });

        return view('home.index', 
            [
                "officialNews" => $officialNewsCache
            ]
        );
    }

    /**
     * Show news by category name
     */
    public function showNewsByCategorySlug($categorySlug)
    {
        $key = "cache_";

        $categoryCache = Cache::remember($key."news.listing.category", Constants::getCacheSeconds(), function () use ($categorySlug)
        {
            return Category::where("slug", $categorySlug)->first();
        });
        if ($categoryCache == null) abort(404);

        $newsByCategoryCache = Cache::remember($key."news.listing.newsByCategory", Constants::getCacheSeconds(), function () use ($categoryCache)
        {
            return News::newsPaginatedByCategory($categoryCache->id);
        });

        return view('news.listing', ["news" => $newsByCategoryCache]);
    }

    public function showNewsBySlug($categorySlug, $newsSlug)
    {
        $category = Category::where("slug", $categorySlug)->first();
        if ($category == null) abort(404);

        $newsItem = News::where("url", $newsSlug)->where("category_id", $category->id)->first();
        if ($newsItem == null) abort(404);
        
        return view('news.detail', ["newsItem" => $newsItem]);
    }

    public function showFunnyListings()
    {
        $key = "cache_";

        $categoryCache = Cache::remember($key."funny.listing.showFunnyListings", Constants::getCacheSeconds(), function ()
        {
            return Category::where("name", Category::CATEGORY_FUNNY)->first();
        });

        $funnyCategoryCache = Cache::remember($key."funny.listing.showFunnyListings", Constants::getCacheSeconds(), function () use ($categoryCache)
        {
            return News::newsPaginatedByCategory($categoryCache->id);
        });

        return view('pages.funny.listing', ["funnyItems" => $funnyCategoryCache]);
    }

    public function showCreatorsListings(Request $request)
    {
        $streams = $this->twitchHelper->getTwitchGamesBySlug($request->gameName);
        $videos = $this->twitchHelper->getTwitchVideosBySlug($request->gameName);
        
        return view('pages.creators.listing', ["streams" => $streams, "videos" => $videos]);
    }

    public function showRemastersListings()
    {
        return view('pages.remasters.listing');
    }

    public function clearCache()
    {
        Cache::flush();
    }
}
