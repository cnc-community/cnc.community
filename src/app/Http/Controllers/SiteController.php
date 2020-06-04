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
            return News::officialNewsPaginated(9);
        });

        $workShopItems = $this->steamHelper->getTopWorkShopItems(Constants::remastersAppId(), 8);

        return view('home.index', 
            [
                "officialNews" => $officialNewsCache,
                "workShopItems" => $workShopItems
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


        $pageCategoryCache = Cache::remember($key."news.listing.newsByCategory", Constants::getCacheSeconds(), function () use ($categoryCache)
        {
            return PageCategory::where("news_category_id", $categoryCache->id)->first();
        });        
        
        $newsByCategoryCache = Cache::remember($key."news.listing.newsByCategory", Constants::getCacheSeconds(), function () use ($categoryCache)
        {
            return News::newsPaginatedByCategory($categoryCache->id);
        });

        return view('news.listing', ["news" => $newsByCategoryCache, "category" => $categoryCache, "pageCategory" => $pageCategoryCache]);
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
        $streams = [];
        $videos = [];
        $gameName = "";
        
        if ($request->gameName == null)
        {
            $streams = $this->twitchHelper->getStreamsByTwitchGames();
        }
        else
        {
            $gameName = $request->gameName;
            $streams = $this->twitchHelper->getTwitchGamesBySlug($request->gameName);
            $videos = $this->twitchHelper->getTwitchVideosBySlug($request->gameName);
        }
        
        return view('pages.creators.listing', [
            "streams" => $streams, 
            "videos" => $videos,
            "gameFullName" => Constants::getTwitchGameBySlug($request->gameName),
            "gameName" => $gameName
        ]);
    }

    public function showRemastersListings()
    {
        $key = "cache_";

        $raWorkShopItems = $this->steamHelper->getTopWorkShopItemsByTagNames(
            "showRemastersListingsRA",
            Constants::remastersAppId(),
            [
                SteamHelper::RedAlertMod(),
                SteamHelper::RedAlertMap(),
            ],
            5
        );

        $tdWorkShopItems = $this->steamHelper->getTopWorkShopItemsByTagNames(
            "showRemastersListingsTD",
            Constants::remastersAppId(),
            [
                SteamHelper::TiberianDawnMod(),
                SteamHelper::TiberianDawnMap(),
            ],
            5
        );
   
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

        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");

        return view('pages.remasters.listing', [
            "raWorkShopItems" => $raWorkShopItems, 
            "tdWorkShopItems" => $tdWorkShopItems, 
            "news" => $newsByCategoryCache,
            "streams" => $streams,
            "videos" => $videos,
            "heroVideo" => $heroVideo
        ]);
    }

    public function showRemastersWorkshopMods()
    {
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");

        $topRedAlertMaps = $this->steamHelper->getTopWorkShopItemsByTagName("topRedAlertMaps", Constants::remastersAppId(), SteamHelper::RedAlertMap(), 20 );
        $topTiberianDawnMaps = $this->steamHelper->getTopWorkShopItemsByTagName("topTiberianDawnMaps", Constants::remastersAppId(), SteamHelper::TiberianDawnMap(), 20 );
        $topTDMods = $this->steamHelper->getTopWorkShopItemsByTagName("topTDMods",Constants::remastersAppId(), SteamHelper::TiberianDawnMod(), 20 );
        $topRAMods = $this->steamHelper->getTopWorkShopItemsByTagName("topRAMods",Constants::remastersAppId(), SteamHelper::RedAlertMod(), 20 );

        return view('pages.remasters.workshop.listings', [
            "heroVideo" => $heroVideo,
            "topRedAlertMaps" => $topRedAlertMaps,
            "topTiberianDawnMaps" => $topTiberianDawnMaps,
            "topTDMods" => $topTDMods,
            "topRAMods" => $topRAMods,
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
        
        $heroVideo = Constants::getVideoWithPoster($categorySlug);
        
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
        
        $heroVideo = Constants::getVideoWithPoster($slugCategory);

        $pageCache = Cache::remember($key, Constants::getCacheSeconds(), function ()  use ($slugCategory, $slug) 
        {
            return Page::checkPageExistsWithSlugs($slugCategory, $slug);
        });
        if ($pageCache == null) abort(404);
        
        if ($pageCache->bladeTemplate() == null)
        {
            return view('pages.detail', array("page" => $pageCache));
        }
        return view($pageCache->bladeTemplate(), array("page" => $pageCache, "heroVideo" => $heroVideo, "slugCategory" => $slugCategory));
    }

    public function clearCache()
    {
        Cache::flush();
    }
}
