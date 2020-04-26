<?php

namespace App\Http\Controllers;

use App\News;
use \Illuminate\Http\Request;

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

        $newsItem->title = $request->title;
        $newsItem->post = $request->post;
        $newsItem->category_id = $request->category_id;
        $newsItem->save();
        
        return redirect()->back();
    }
}
