<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Sites\PPMFeed;
use App\Http\Sites\DTAFeed;
use App\Http\Services\XMLFeedParser;
use App\News;

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
        $news = News::all();
        return view('home', ["news" => $news]);
    }

    /**
     * Show news by category name
     */
    public function showNewsByCategorySlug($categorySlug)
    {
        $category = Category::where("slug", $categorySlug)->first();
        if ($category == null) abort(404);

        $newsByCategory = News::newsPaginatedByCategory($category->id);

        return view('news.listing', ["news" => $newsByCategory]);
    }
}
