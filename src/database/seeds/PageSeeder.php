<?php

use Illuminate\Database\Seeder;
use App\Page;
use App\PageTemplate;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gameTemplate = new PageTemplate();
        $gameTemplate->name = "Game";
        $gameTemplate->blade_name = "games.detail";
        $gameTemplate->save();

        $this->create("Red Alert - Singleplayer", "Red Alert Single Player", "red-alert", "singleplayer", $gameTemplate->id);
        $this->create("Red Alert - Online", "Red Alert Online", "red-alert", "online", $gameTemplate->id);
    }

    private function create($title, $description, $categorySlug, $slug, $templateId)
    {
        $page = new Page();
        $page->title = $title;
        $page->description = $description;
        $page->slug_category = $categorySlug;
        $page->template_id = $templateId;
        $page->slug = $slug;
        $page->save();
    }
}
