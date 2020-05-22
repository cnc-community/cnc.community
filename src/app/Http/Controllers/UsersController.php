<?php

namespace App\Http\Controllers;

use App\NewsFeedQueue;
use App\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
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
        $users = User::all();
        return view('admin.users.listings', ["users" => $users]);
    }

    public function edit($id)
    {
        $userItem = User::find($id);
        if ($userItem == null) abort(404);
        return view('admin.users.edit', ["userItem" => $userItem]);
    }

    public function save(Request $request)
    {
        $userItem = User::find($request->id);
        if ($userItem == null)
        {
            return redirect("admin/users");
        }

        $userItem->name = $request->name;
        $userItem->email = $request->email;
        $userItem->role = $request->role;

        if (strlen($request->password) > 0)
        {
            $userItem->password = bcrypt($request->password);
        }
        
        $userItem->save();
        
        return redirect()->back();
    }
}
