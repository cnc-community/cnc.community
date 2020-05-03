<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    protected $table = 'page_category';

    public function __construct()
    {
        
    }

    public static function categoryBySlug($slug)
    {
        return PageCategory::where("slug", $slug)->first();
    }

    public static function createCategory($title, $description, $slug, $templateId)
    {
        $category = new PageCategory();
        $category->title = $title;
        $category->description = $description;
        $category->slug = $slug;
        $category->template_id = $templateId;
        $category->save();
        return $category;
    }

    public function bladeTemplate()
    {
        $template = PageTemplate::find($this->template_id);
        if ($template == null) return null;
        return $template->blade_name;
    }
}
