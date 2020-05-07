<?php

namespace App\Http\Controllers;

use App\News;
use App\Http\Services\FeedHelper;
use Illuminate\Http\Request;

class NewsController extends Controller
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
        $news = News::all();
        return view('admin.news.listings', ["news" => $news]);
    }

    public function edit($id)
    {
        $newsItem = News::find($id);
        if ($newsItem == null) abort(404);
        return view('admin.news.edit', ["newsItem" => $newsItem]);
    }
    
    public function getCreate(Request $request)
    {
        return view('admin.news.add');
    }

    public function create(Request $request)
    {
        $path = $request->file("image");
        $image = null;
        if ($path)
        {
            $image = FeedHelper::createImageFromUrl($path);
        }

        $newsItem = News::createNewsItem($request->title, $request->post, null, $image, $request->category_id);
        return redirect('/admin/news/edit/' . $newsItem->id);
    }

    public function save(Request $request)
    {
        $newsItem = News::find($request->id);
        if ($newsItem == null)
        {
            return redirect("admin/news");
        }

        // Reject news, marks as rejected and deletes
        if ($request->status === News::DELETE)
        {
            $newsItem->rejectQueuedItem();
            return redirect("admin/news");
        }
        
        $path = $request->file("image");
        if ($path)
        {
            $image = FeedHelper::createImageFromUrl($path);
            $newsItem->image = $image;
        }

        $newsItem->title = $request->title;
        $newsItem->post = $request->post;
        $newsItem->category_id = $request->category_id;
        $newsItem->save();
        
        return redirect()->back();
    }
}
