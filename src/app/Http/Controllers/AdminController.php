<?php

namespace App\Http\Controllers;

use App\News;
use App\Http\Services\FeedHelper;
use App\NewsFeedQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
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
        $news = News::all();
        return view('admin.index', ["news" => $news]);
    }
}
