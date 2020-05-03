<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function __construct()
    {
        
    }

    public static function createPage($title, $description, $categoryId, $slug, $templateId)
    {        
        $page = Page::where("slug", $slug)->where("category_id", $categoryId)->first();
        if ($page != null)
        {
            return null;
        }

        $page = new Page();
        $page->title= $title;
        $page->description = $description;
        $page->category_id = $categoryId;
        $page->slug = $slug;
        $page->template_id = $templateId;
        $page->save();

        return $page;
    }

    public function updatePage($title, $description, $templateId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->template_id = $templateId;
        $this->save();
    }

    public static function checkPageExistsWithSlugs($slugCategory, $slug)
    {
        $category = PageCategory::where("slug", $slugCategory)->first();
        $page = Page::where("slug", $slug)->where("category_id", $category->id)->first();
        return $page;
    }
    
    public static function getPagesByCategory($categoryId)
    {
        return Page::where("category_id", $categoryId)->get();
    }

    public function category()
    {
        return PageCategory::find($this->category_id);
    }

    public static function getPageCategories()
    {
        return PageCategory::all();
    }

    public function bladeTemplate()
    {
        $template = PageTemplate::find($this->template_id);
        if ($template == null) return null;
        return $template->blade_name;
    }

    public function url()
    {
        return "/" . $this->category()->slug . "/" . $this->slug;
    }
}
