<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function __construct()
    {
        
    }

    public static function createPage($title, $description, $slugCategory, $slug, $templateId)
    {        
        $exists = Page::checkPageExistsWithSlugs($slugCategory, $slug);
        if ($exists != null)
        {
            return null;
        }

        $page = new Page();
        $page->title= $title;
        $page->description = $description;
        $page->slug_category= $slugCategory;
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
        return Page::where("slug_category", "=", $slugCategory)
            ->where("slug", "=", $slug)
            ->first();
    }
    
    public static function getPagesByCategory($categoryId)
    {
        return Page::where("category_id", $categoryId)->get();
    }

    public function category()
    {
        return PageCategory::find($this->category_id);
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
