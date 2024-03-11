<?php

namespace Database\Seeders;

use App\Category;
use App\CustomFieldNames;
use App\HowToContentSeed;
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

        $this->createGameCategoryPage("Tiberian Dawn", "tiberian-dawn", "Command & Conquer", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert", "red-alert", "Command & Conquer: Red Alert", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Tiberian Sun", "tiberian-sun", "Command & Conquer: Tiberian Sun", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert 2", "red-alert-2", "Command & Conquer: Red Alert 2", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert 3", "red-alert-3", "Command & Conquer: Red Alert 3", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Renegade", "renegade", "Command & Conquer: Renegade", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Generals", "generals", "Command & Conquer: Generals", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Command & Conquer 3", "command-and-conquer-3", "Command & Conquer 3: Tiberium Wars", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Command & Conquer 4", "command-and-conquer-4", "Command & Conquer 4: Tiberian Twilight", $gameTemplate, $categoryTemplate);

        $this->createNewsCategory("Command & Conquer Remastered News", "command-and-conquer-remastered-news");
    }

    private function createNewsCategory($name, $slug)
    {
        $category = new Category();
        $category->name = $name;
        $category->slug = $slug;
        $category->save();
        return $category;
    }

    private function createGameCategoryPage($title, $slug, $description, $gameTemplate, $categoryTemplate)
    {
        $newsCategory = $this->createNewsCategory($title . " News", $slug . "-news");

        $pageCategory = new PageCategory();
        $pageCategory->title = $title;
        $pageCategory->slug = $slug;
        $pageCategory->template_id = $categoryTemplate->id;
        $pageCategory->description = $description;
        $pageCategory->news_category_id = $newsCategory->id;
        $pageCategory->save();

        $this->create("How to play " . $title, "Play " . $title . " campaign and online with thousands of players", "how-to-play", $gameTemplate->id, $pageCategory->id);
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
        $body = HowToContentSeed::Renegade();
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, null);

        $key = CustomFieldNames::HOW_TO_PLAY_VIDEO;
        $name = "Video Tutorial";
        $body = '';
        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, $pageId, $content->id, null);
    }
}
