<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageCategory;
use App\PageTemplate;
use \Illuminate\Http\Request;
use App\PageContent;
use App\PageCustomField;
use Illuminate\Support\Facades\Cache;
use App\Constants;

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
        $key = "cache_" . $category;

        $categoryCache = Cache::remember($key."category", Constants::CACHE_SECONDS, function () use ($category) 
        {
            return PageCategory::categoryBySlug($category);
        });
        
        $pagesCache = Cache::remember($key."pages", Constants::CACHE_SECONDS, function ()  use ($categoryCache) 
        {
            return Page::getPagesByCategory($categoryCache->id);
        });
        
        $template = $categoryCache->bladeTemplate();

        if ($template == null)
        {
            return view('pages.category', ["pages" => $pagesCache, "category" => $categoryCache]);
        }
        return view($template, ["pages" => $pagesCache, "category" => $categoryCache]);
    }

    /**
     * Show page by category and slug
     */
    public function showPageBySlug($slugCategory, $slug)
    {
        $key = "cache_" . $slugCategory . "_" . $slug;
        $pageCache = Cache::remember($key, Constants::CACHE_SECONDS, function ()  use ($slugCategory, $slug) 
        {
            return Page::checkPageExistsWithSlugs($slugCategory, $slug);
        });
        if ($pageCache == null) abort(404);
        
        if ($pageCache->bladeTemplate() == null)
        {
            return view('pages.detail', array("page" => $pageCache));
        }
        return view($pageCache->bladeTemplate(), array("page" => $pageCache));
    }

    /**
     * Admin page listings
     */
    public function listPages()
    {
        $pages = Page::all();
        $categories = PageCategory::all();

        return view('admin.pages.listings', ["pages" => $pages, "categories" => $categories]);
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
        $pageCategories = Page::getPageCategories();

        return view('admin.pages.add', ['templates' => $templates, 'categories' => $pageCategories]);
    }

    /**
     * Admin create page
     */
    public function createPage(Request $request) 
    {
        $pageTemplate = PageTemplate::find($request->template);
        $pageCategory = PageCategory::find($request->category);

        $page = Page::createPage(
            $request->title, 
            $request->description, 
            $pageCategory->id, 
            $request->slug, 
            $pageTemplate->id
        );

        if ($page == null)
        {
            $request->session()->flash('error', 'Your slug category and slugs already exist in another page.');
            return redirect("/admin/pages/add");
        }

        return redirect("/admin/pages/edit/" . $page->id);
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

    /**
     * Admin add page category
     */
    public function addPageCategory(Request $request)
    {
        $templates = PageTemplate::all();
        return view('admin.pages.category.add', ['templates' => $templates]);
    }

    /**
     * Admin edit page category
     */
    public function editPageCategory($id)
    {
        $templates = PageTemplate::all();
        $category = PageCategory::find($id);
        if ($category == null) abort(404);

        $customFields = PageCustomField::getCustomFieldsByPageCategoryId($category->id);
        return view('admin.pages.category.edit', ['templates' => $templates, 'category' => $category, 'customFields' => $customFields]);
    }

    /**
     * Admin add custom page category fields 
     */
    public function addPageCategoryCustomField($id)
    {
        $category = PageCategory::find($id);
        return view('admin.pages.category.fields.add', ['category' => $category]);
    }

    /**
     * Admin save custom page category fields 
     */
    public function createPageCategoryCustomField(Request $request)
    {
        $category = PageCategory::find($request->id);
        if ($category == null)
        {
            $request->session()->flash('error', 'Page does not exist.');
            return redirect("/admin/pages/");
        }

        $pageContent = PageContent::createPageContent("");

        PageCustomField::createCustomField($request->key, $request->name,null, $pageContent->id, $category->id);
        return redirect("/admin/pages/category/edit/" . $request->id);
    }

    /**
     * Admin save page category
     */
    public function savePageCategory(Request $request)
    {
        $pageTemplate = PageTemplate::find($request->template);

        $inputs = $request->all();
        foreach($inputs as $inputName => $inputValue)
        {
            if (strpos($inputName, 'custom_field_') !== false) 
            {
                $customFieldId = str_replace("custom_field_", "", $inputName);
                PageCustomField::updateContent($customFieldId, $inputValue);
            }
        }

        $category = PageCategory::find($request->id);
        $category->updateCategory(
            $request->title, 
            $request->description, 
            $request->slug, 
            $pageTemplate->id
        );

        $request->session()->flash('status', 'Category saved');
        return redirect("/admin/pages/category/edit/". $category->id);
    }


    public function createPageCategory(Request $request)
    {
        $pageTemplate = PageTemplate::find($request->template);

        $category = PageCategory::createCategory(
            $request->title, 
            $request->description, 
            $request->slug, 
            $pageTemplate->id
        );

        $request->session()->flash('status', 'Category saved');
        return redirect("/admin/pages/category/edit/". $category->id);
    }


    /**
     * Admin add custom field
     */
    public function addField($id)
    {
        $page = Page::find($id);
        return view('admin.pages.fields.add', ['page' => $page]);
    }


    /**
     * Admin - create custom fields
     */
    public function createCustomField(Request $request, $id) 
    {
        $page = Page::find($id);
        if ($page == null)
        {
            $request->session()->flash('error', 'Page does not exist.');
            return redirect("/admin/pages/");
        }

        $pageContent = PageContent::createPageContent("");

        PageCustomField::createCustomField($request->key, $request->name, $page->id, $pageContent->id, null);
        return redirect("/admin/pages/edit/" . $page->id);
    }
}
