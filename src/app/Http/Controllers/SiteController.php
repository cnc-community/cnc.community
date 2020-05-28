<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use App\Page;
use App\Constants;
use App\Http\Services\SteamHelper;
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
        $this->steamHelper = new SteamHelper();
        
        // TEMP staging only access 
        $this->middleware('auth');
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
        $key = "cache_";

        $workShopItems = $this->steamHelper->getTopWorkShopItems(Constants::remastersAppId(), 16);
   
        $streams = $this->twitchHelper->getTwitchGamesBySlug("remasters");
        $videos = $this->twitchHelper->getTwitchVideosBySlug("remasters");

        $categoryCache = Cache::remember($key."pages.remasters.listing.categoryCache", Constants::getCacheSeconds(), function ()
        {
            return Category::where("name", Category::CATEGORY_REMASTERS)->first();
        });

        $newsByCategoryCache = Cache::remember($key."pages.remasters.listing.showRemastersListings", 
            Constants::getCacheSeconds(), function () use ($categoryCache)
        {
            return News::newsPaginatedByCategory($categoryCache->id);
        });

        $heroVideo = Constants::getVideoWithPoster()["command-and-conquer-remastered"];

        return view('pages.remasters.listing', [
            "workShopItems" => $workShopItems, 
            "news" => $newsByCategoryCache,
            "streams" => $streams,
            "videos" => $videos,
            "heroVideo" => $heroVideo
        ]);
    }

    /**
     * Get page category and 
     */
    public function showPageByCategory($categorySlug)
    {
        $key = "cache_" . $categorySlug;

        $categoryCache = Cache::remember($key."category", Constants::getCacheSeconds(), function () use ($categorySlug) 
        {
            return PageCategory::categoryBySlug($categorySlug);
        });
        
        if ($categoryCache == null)
        {
            abort(404);
        }
        
        $pagesCache = Cache::remember($key."pages", Constants::getCacheSeconds(), function ()  use ($categoryCache) 
        {
            return Page::getPagesByCategory($categoryCache->id);
        });

        $newsByCategoryCache = Cache::remember($key."home.index.communityNews", Constants::getCacheSeconds(), function () use($categoryCache)
        {
            return News::newsByCategoryId($categoryCache->news_category_id);
        });

        $streams = $this->twitchHelper->getTwitchGamesBySlug($categorySlug);
        $videos = $this->twitchHelper->getTwitchVideosBySlug($categorySlug);

        $template = $categoryCache->bladeTemplate();
        $template == null ? "pages.category": $template;
        
        $heroVideo = Constants::getVideoWithPoster()[$categorySlug];
        
        return view($template, [
            "heroVideo" => $heroVideo,
            "pages" => $pagesCache, 
            "category" => $categoryCache, 
            "news" => $newsByCategoryCache,
            "streams" => $streams,
            "videos" => $videos
        ]);
    }

    /**
     * Show page by category and slug
     */
    public function showPageBySlug($slugCategory, $slug)
    {
        $key = "cache_" . $slugCategory . "_" . $slug;
        $pageCache = Cache::remember($key, Constants::getCacheSeconds(), function ()  use ($slugCategory, $slug) 
        {
            return Page::checkPageExistsWithSlugs($slugCategory, $slug);
        });
        if ($pageCache == null) abort(404);
        
        if ($pageCache->bladeTemplate() == null)
        {
            return view('pages.detail', array("page" => $pageCache));
        }
        return view($pageCache->bladeTemplate(), array("page" => $pageCache));
    }

    public function clearCache()
    {
        Cache::flush();
    }
}
