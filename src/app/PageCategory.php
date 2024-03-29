<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    protected $connection= 'mysql';
    protected $table = 'page_category';

    public function __construct()
    {
        
    }

    public function url()
    {
        return "/". $this->slug;
    }

    public static function categoryBySlug($slug)
    {
        return PageCategory::where("slug", $slug)->first();
    }

    public static function createCategory($title, $description, $slug, $templateId)
    {
        $category = new PageCategory();
        $category->saveCategory($title, $description, $slug, $templateId);
        return $category;
    }

    public function updateCategory($title, $description, $slug, $templateId)
    {
        return $this->saveCategory($title, $description, $slug, $templateId);
    }

    private function saveCategory($title, $description, $slug, $templateId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
        $this->template_id = $templateId;
        $this->save();
        return $this;
    }

    public function bladeTemplate()
    {
        $template = PageTemplate::find($this->template_id);
        if ($template == null) return null;
        return $template->blade_name;
    }
}
