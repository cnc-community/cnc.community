<?php

namespace App\Http\Controllers;

use App\Http\Services\XMLFeedParser;
use App\Http\Services\RedditFeedParser;
use App\Http\Services\SteamFeedParser;
use App\Constants;
use App\NewsFeedQueue;
use Illuminate\View\View;

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
        View::share('queue_count', NewsFeedQueue::count());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->runTask();

        return redirect("/admin/queue");
    }

    public function runTask()
    {
        $steamFeed = new SteamFeedParser("https://api.steampowered.com/ISteamNews/GetNewsForApp/v2/", Constants::remastersAppId());
        $steamFeed->run();

        $ppmFeed =  new XMLFeedParser("https://www.ppmsite.com/news/rss/ppm_all.xml");
        $ppmFeed->run();

        $reddit = new RedditFeedParser("https://www.reddit.com/r/commandandconquer.json");
        $reddit->run();
    }
}
