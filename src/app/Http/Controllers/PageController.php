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
     * Get page category and 
     */
    public function showPageByCategory($category)
    {
        $pages = Page::where("slug_category", $category)->get();
        return view('pages.category', ["pages" => $pages]);
    }

    /**
     * Show page by category and slug
     */
    public function showPageBySlug($slugCategory, $slug)
    {
        $page = Page::where("slug_category", $slugCategory)->where("slug", $slug)->first();
        if ($page == null) abort(404);
        
        if ($page->bladeTemplate() == null)
        {
            return view('pages.detail', array("page" => $page));
        }

        return view($page->bladeTemplate(), array("page" => $page));
    }

    /**
     * Admin page listings
     */
    public function listPages()
    {
        $pages = Page::all();
        return view('admin.pages.listings', ["pages" => $pages]);
    }

    /**
     * Admin edit page
     */
    public function editPage($id)
    {   
        $page = Page::find($id);
        if ($page == null) abort(404);

        return view('admin.pages.edit', array("page" => $page));
    }
}
