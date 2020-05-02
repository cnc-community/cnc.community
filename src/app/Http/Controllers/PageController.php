<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageTemplate;
use \Illuminate\Http\Request;
use App\PageContent;
use App\PageCustomField;

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

        $templates = PageTemplate::all();
        $customFields = PageCustomField::getCustomFieldsByPageId($page->id);

        return view('admin.pages.edit' , ['templates' => $templates, 'page' => $page, "customFields" => $customFields]);
    }

    /**
     * Admin add page
     */
    public function addPage(Request $request)
    {
        $templates = PageTemplate::all();
        return view('admin.pages.add', ['templates' => $templates]);
    }

    /**
     * Admin create page
     */
    public function createPage(Request $request) 
    {
        $pageTemplate = PageTemplate::find($request->template);
        $pageContent = PageContent::createPageContent($request->content);

        $page = Page::createPage(
            $request->title, 
            $request->description, 
            $request->slug_category, 
            $request->slug, 
            $pageTemplate->id, 
            $pageContent->id
        );

        if ($page == null)
        {
            $request->session()->flash('error', 'Your slug category and slugs already exist in another page.');
            return redirect("/admin/pages/add");
        }

        return redirect("/admin/pages");
    }

    /**
     * Admin create page
     */
    public function savePage(Request $request) 
    {
        $pageTemplate = PageTemplate::find($request->template);
        
        $page = Page::find($request->id);
        if ($page == null)
        {
            abort(404);
        }

        $inputs = $request->all();
        foreach($inputs as $inputName => $inputValue)
        {
            if (strpos($inputName, 'custom_field_') !== false) 
            {
                $customFieldId = str_replace("custom_field_", "", $inputName);
                PageCustomField::updateContent($customFieldId, $inputValue);
            }
        }

        $page->updatePage(
            $request->title, 
            $request->description, 
            $pageTemplate->id, 
            $request->content
        );

        $request->session()->flash('status', 'Page saved');
        return redirect("/admin/pages/edit/" . $request->id);
    }
}
