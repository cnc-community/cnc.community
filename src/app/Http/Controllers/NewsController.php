<?php

namespace App\Http\Controllers;

use App\News;
use App\Http\Services\FeedHelper;
use App\NewsCategories;
use App\NewsCategory;
use App\NewsFeedQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
        View::share('queue_count', NewsFeedQueue::count());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = News::orderByDesc("created_at")->paginate(20);
        return view('admin.news.listings', ["news" => $news]);
    }

    public function edit($id)
    {
        $newsItem = News::find($id);
        if ($newsItem == null) abort(404);

        $users = \App\User::all();
        return view('admin.news.edit', ["newsItem" => $newsItem, "users" => $users]);
    }
    
    public function getCreate(Request $request)
    {
        $users = \App\User::all();

        return view('admin.news.add', ["users" => $users]);
    }

    public function create(Request $request)
    {
        $newsItemModel = new News();

        News::updateNewsItem(
            $newsItemModel, 
            $request->title,
            $request->category_id,
            $request->categories,
            $request->file("image"),
            $request->author,
            $request->post,
            $request->excerpt,
            $request->type,
            $request->url
        );

        $request->session()->flash("status", "News created");
        return redirect("/admin/news/edit/" . $newsItemModel->id);
    }

    public function save(Request $request)
    {
        $newsItemModel = News::find($request->id);
        if ($newsItemModel == null)
        {
            return redirect("admin/news");
        }

        if ($request->status === News::DELETE)
        {
            $request->session()->flash("status", "Post Deleted");
            $newsItemModel->delete();
            return redirect("admin/news");
        }

        News::updateNewsItem(
            $newsItemModel, 
            $request->title,
            $request->category_id == null ? $newsItemModel->category_id : $request->category_id,
            $request->categories,
            $request->file("image"),
            $request->author,
            $request->post,
            $request->excerpt,
            $newsItemModel->type,
            $newsItemModel->url
        );

        $request->session()->flash("status", "Post saved");
        return redirect()->back();
    }
}