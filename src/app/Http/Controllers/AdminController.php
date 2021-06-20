<?php

namespace App\Http\Controllers;

use App\Http\Services\FeedHelper;
use App\NewsFeedQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        View::share('queue_count', NewsFeedQueue::count());
    }

    public function uploadImageViaEditor(Request $request)
    {
        if ($request->hasFile("upload"))
        {
            $path = $request->file("upload");
            if ($path)
            {
                return asset(FeedHelper::storeImage($path));
            }
        }
        return "";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }
}
