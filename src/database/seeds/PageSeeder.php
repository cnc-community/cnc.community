<?php

use App\CustomFieldNames;
use Illuminate\Database\Seeder;
use App\Page;
use App\PageContent;
use App\PageCustomField;
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

        $this->createDemoCustomFields($page->id);
    }

    private function createDemoCustomFields($pageId)
    {
        $key = CustomFieldNames::HOW_TO_PLAY_STEPS;
        $name = "How to play";
        $body = "<div>1,2,3, Help me!</div>";
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, 0);


        $key = CustomFieldNames::HOW_TO_PLAY_VIDEO;
        $name = "Video Tutorial";
        $body = '<iframe width="560" height="315" src="https://www.youtube.com/embed/9iMfypQj3k0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, 0);
    }
}
