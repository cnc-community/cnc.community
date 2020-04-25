<?php

namespace App\Http\Controllers;

use App\NewsFeedQueue;
use \Illuminate\Http\Request;

class AdminController extends Controller
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
        $news = NewsFeedQueue::all();
        return view('admin.queue.queue', ["news" => $news]);
    }

    public function edit($id)
    {
        $newsItem = NewsFeedQueue::find($id);
        if ($newsItem == null) abort(404);
        return view('admin.queue.edit', ["newsItem" => $newsItem]);
    }

    public function save(Request $request)
    {
        $queuedItem = NewsFeedQueue::find($request->id);
        if ($queuedItem == null)
        {
            return redirect("admin.queue");
        }

        // Reject news, marks as rejected and deletes
        if ($request->status === NewsFeedQueue::REJECTED)
        {
            $queuedItem->rejectQueuedItem();
            return redirect("admin/queue");
        }

        if ($request->status === NewsFeedQueue::APPROVED)
        {
            $queuedItem->approveQueuedItem();
            return redirect("admin/queue");
        }
        
        $queuedItem->post = $request->post;
        $queuedItem->save();
        
        return redirect()->back();
    }
}
