<?php

namespace App\Http\Controllers;

use App\Page;
use \Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show page by slug
     */
    public function showPageBySlug($slugCategory, $slug)
    {
        $page = Page::where("slug_category", $slugCategory)->where("slug", $slug)->first();
        if ($page == null) abort(404);
        
        return view('pages.detail', array("page" => $page));
    }

    public function listPages()
    {
        $pages = Page::all();
        return view('admin.pages.listings', ["pages" => $pages]);
    }

    public function editPage($id)
    {   
        $page = Page::find($id);
        if ($page == null) abort(404);

        return view('admin.pages.edit', array("page" => $page));
    }
}
