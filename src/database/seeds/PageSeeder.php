<?php

use App\CustomFieldNames;
use Illuminate\Database\Seeder;
use App\Page;
use App\PageContent;
use App\PageCustomField;
use App\PageTemplate;
use App\PageCategory;

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
        $gameTemplate->name = "Game Detail - How to Play";
        $gameTemplate->blade_name = "games.detail-how-to-play";
        $gameTemplate->save();

        $categoryTemplate = new PageTemplate();
        $categoryTemplate->name = "Category Template - Games Listing";
        $categoryTemplate->blade_name = "games.category-listing";
        $categoryTemplate->save();

        $pageCategory = new PageCategory();
        $pageCategory->title = "Red Alert";
        $pageCategory->slug = "red-alert";
        $pageCategory->template_id = $categoryTemplate->id;
        $pageCategory->description = "Command & Conquer: Red Alert";
        $pageCategory->save();

        $this->createDemoCustomFieldsForPageCategories($pageCategory->id);

        $this->create("Red Alert - Campaign", "Red Alert - Single Player", "campaign", $gameTemplate->id, $pageCategory->id);
        $this->create("Red Alert - Online", "Red Alert - Online", "online", $gameTemplate->id, $pageCategory->id);
    }

    private function create($title, $description, $slug, $templateId, $categoryId)
    {
        $page = new Page();
        $page->title = $title;
        $page->description = $description;
        $page->template_id = $templateId;
        $page->slug = $slug;
        $page->category_id = $categoryId;
        $page->save();

        $this->createDemoCustomFields($page->id);
    }

    private function createDemoCustomFields($pageId)
    {
        $key = CustomFieldNames::HOW_TO_PLAY_STEPS;
        $name = "How to play";
        $body = "<div><ul><li>Step 1 - Kane</li><li>Step 2 - Yuri</li></ul></div>";
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, null);

        $key = CustomFieldNames::HOW_TO_PLAY_VIDEO;
        $name = "Video Tutorial";
        $body = '<iframe width="560" height="315" src="https://www.youtube.com/embed/9iMfypQj3k0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, null);
    }

    private function createDemoCustomFieldsForPageCategories($categoryId)
    {
        $key = CustomFieldNames::WHERE_TO_GET_GAMES;
        $name = "Where to get the games";
        $body = 'CnCNet, Origin, Physical etc';
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, null, $content->id, $categoryId);
    }
}
