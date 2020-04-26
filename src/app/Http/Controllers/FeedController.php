<?php

namespace App\Http\Controllers;

use App\Http\Sites\PPMFeed;
use App\Http\Sites\DTAFeed;
use App\Http\Services\XMLFeedParser;
use App\Http\Services\RedditFeedParser;
use App\News;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*
        $ppmFeed = new PPMFeed(
            new XMLFeedParser("https://www.ppmsite.com/news/rss/ppm_all.xml")
        );

        $dtaFeed = new DTAFeed(
            new XMLFeedParser("https://rss.moddb.com/mods/the-dawn-of-the-tiberium-age/articles/feed/rss.xml")
        );

        $ppmFeed->run();
        $dtaFeed->run();
        */

        $test = new RedditFeedParser("https://www.reddit.com/r/commandandconquer.json");
        return $test->run();

        return redirect("admin/queue");
    }
}
