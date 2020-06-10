<?php

namespace App\Http\Controllers;

use App\NewsCategory;
use App\NewsFeedQueue;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\View as FacadesView;

class QueuedNewsController extends Controller
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
     * Show the queued listings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = NewsFeedQueue::orderByDesc("created_at")->paginate(20);
        return view('admin.queue.listings', ["news" => $news]);
    }

    /**
     * Edit an existing queued item
     */
    public function edit($id)
    {
        $newsItem = NewsFeedQueue::find($id);
        if ($newsItem == null) abort(404);
        return view('admin.queue.edit', ["newsItem" => $newsItem]);
    }

    /** 
     * Save queue data and status
     */
    public function save(Request $request)
    {
        $queuedItem = NewsFeedQueue::find($request->id);
        if ($queuedItem == null)
        {
            return redirect("admin/queue");
        }

        // Reject news, marks as rejected and deletes
        if ($request->status === NewsFeedQueue::REJECTED)
        {
            $queuedItem->rejectQueuedItem();
            return redirect("admin/queue");
        }

        $queuedItem->title = $request->title;
        $queuedItem->post = $request->post;
        $queuedItem->category_id = $request->category_id;
        $queuedItem->save();

        if ($request->status === NewsFeedQueue::APPROVED)
        {
            $queuedItem->approveQueuedItem();
            return redirect("admin/queue");
        }
        
        return redirect()->back();
    }
}
