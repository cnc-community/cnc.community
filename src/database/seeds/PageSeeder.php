<?php

use Illuminate\Database\Seeder;
use App\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create("Red Alert - Singleplayer", "Red Alert Single Player", "red-alert", "singleplayer");
        $this->create("Red Alert - Online", "Red Alert Online", "red-alert", "online");
    }

    private function create($title, $description, $categorySlug, $slug)
    {
        $page = new Page();
        $page->title = $title;
        $page->description = $description;
        $page->slug_category = $categorySlug;
        $page->slug = $slug;
        $page->save();
    }
}
