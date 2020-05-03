<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Sites\PPMFeed;
use App\Http\Sites\DTAFeed;
use App\Http\Services\XMLFeedParser;
use App\News;
use App\Page;
use App\Constants;
use App\PageCategory;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $key = "cache_";

        $pageCategoriesCache = Cache::remember($key."home.index.pageCategories", Constants::CACHE_SECONDS, function () 
        {
            return PageCategory::all();
        });

        $communityNewsCache = Cache::remember($key."home.index.communityNews", Constants::CACHE_SECONDS, function () 
        {
            return News::communityNewsPaginated();
        });

        $officialNewsCache = Cache::remember($key."home.index.officialNews", Constants::CACHE_SECONDS, function () 
        {
            return News::officialNewsPaginated();
        });

        return view('home.index', 
            [
                "pageCategories" => $pageCategoriesCache,
                "communityNews" => $communityNewsCache,
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

        $categoryCache = Cache::remember($key."news.listing.category", Constants::CACHE_SECONDS, function () use ($categorySlug)
        {
            return Category::where("slug", $categorySlug)->first();
        });
        if ($categoryCache == null) abort(404);

        $newsByCategoryCache = Cache::remember($key."news.listing.newsByCategory", Constants::CACHE_SECONDS, function () use ($categoryCache)
        {
            return News::newsPaginatedByCategory($categoryCache->id);
        });

        return view('news.listing', ["news" => $newsByCategoryCache]);
    }
}
