<?php

namespace App\Http\Controllers;

use App\Http\Services\XMLFeedParser;
use App\Http\Services\RedditFeedParser;
use App\Http\Services\SteamFeedParser;
use App\Constants;
use App\NewsFeedQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as FacadesView;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        FacadesView::share('queue_count', NewsFeedQueue::count());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Log::debug("Running feeds");
        
        $this->runTask();
        $this->runTaskDaily();

        return redirect("/admin/queue");
    }

    public function runTask()
    {
        $reddit = new RedditFeedParser("https://www.reddit.com/r/commandandconquer.json");
        $reddit->run();
    }

    public function runTaskDaily()
    {
        $steamFeed = new SteamFeedParser("https://api.steampowered.com/ISteamNews/GetNewsForApp/v2/", Constants::remastersAppId());
        $steamFeed->run();

        $ppmFeed =  new XMLFeedParser("https://www.ppmsite.com/news/rss/ppm_cnc.xml", "PPM");
        $ppmFeed->run();

        $ppmFeed =  new XMLFeedParser("https://www.ppmsite.com/news/rss/ppm_cncnews.xml", "PPM");
        $ppmFeed->run();

        $w3dhubFeed = new XMLFeedParser("https://w3dhub.com/forum/rss/1-w3d-hub-news.xml/?member_id=1484&key=2dbafbb11199210b6b0d3b07ef4590ab", "W3DHub");
        $w3dhubFeed->run();

        $cncnzFeed =  new XMLFeedParser("https://forums.cncnz.com/forum/27-command-conquer-news.xml", "CNCNZ");
        $cncnzFeed->run();
    }
}
