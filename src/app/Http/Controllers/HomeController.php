<?php

namespace App\Http\Controllers;

use App\Http\Sites\PPMFeed;
use App\Http\Sites\DTAFeed;
use App\Http\Services\XMLFeedParser;
use App\News;

class HomeController extends Controller
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
        $ppmFeed = new PPMFeed(
            new XMLFeedParser("https://www.ppmsite.com/news/rss/ppm_all.xml")
        );

        $dtaFeed = new DTAFeed(
            new XMLFeedParser("https://rss.moddb.com/mods/the-dawn-of-the-tiberium-age/articles/feed/rss.xml")
        );

        $ppmFeed->run();
        $dtaFeed->run();

        $news = News::all();
        return view('home', ["news" => $news]);
    }
}
