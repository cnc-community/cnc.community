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

        $this->createGameCategoryPage("Tiberian Dawn", "tiberian-dawn", "Command & Conquer", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert", "red-alert", "Command & Conquer: Red Alert", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Tiberian Sun", "tiberian-sun", "Command & Conquer: Tiberian Sun", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert 2", "red-alert-2", "Command & Conquer: Red Alert 2", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Renegade", "renegade", "Command & Conquer: Renegade", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Generals", "generals", "Command & Conquer: Generals", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Red Alert 3", "red-alert-3", "Command & Conquer: Red Alert 3", $gameTemplate, $categoryTemplate);
        $this->createGameCategoryPage("Command & Conquer 3", "command-and-conquer-3", "Command & Conquer: Tiberium Wars", $gameTemplate, $categoryTemplate);
    }

    private function createGameCategoryPage($title, $slug, $description, $gameTemplate, $categoryTemplate)
    {
        $pageCategory = new PageCategory();
        $pageCategory->title = $title;
        $pageCategory->slug = $slug;
        $pageCategory->template_id = $categoryTemplate->id;
        $pageCategory->description = $description;
        $pageCategory->save();

        $this->createDemoCustomFieldsForPageCategories($pageCategory);

        $this->create($title ." - Campaign", $title ." - Single Player", "campaign", $gameTemplate->id, $pageCategory->id);
        $this->create($title ." - Online", $title ." - Online", "online", $gameTemplate->id, $pageCategory->id);
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

    private function createDemoCustomFieldsForPageCategories($category)
    {
        // $key = CustomFieldNames::WHERE_TO_GET_GAMES;
        // $name = "Where to get the games";
        // $body = 'CnCNet, Origin, Physical etc';
        // $content = PageContent::createPageContent($body);
        // PageCustomField::createCustomField($key, $name, null, $content->id, $categoryId);

        $key = CustomFieldNames::HOW_TO_PLAY_LISTINGS;
        $name = "How to play Red Alert ". $category->title;
        $body = '
            <div class="boxes">
                <a href="#" class="box '.$category->slug.'-campaign">
                    <div class="description">
                        <h3 class="text-uppercase">
                            Singleplayer
                        </h3>
                        <p>
                            Consectetur adipiscing elit, sed do eiusmod
                            tempor incidid unt
                        </p>
                    </div>
                </a>
                <a href="#" class="box '.$category->slug.'-multiplayer">
                    <div class="description">
                        <h3 class="text-uppercase">
                            Multiplayer
                        </h3>
                        <p>
                            Consectetur adipiscing elit, sed do eiusmod
                            tempor incidid unt
                        </p>
                    </div>
                </a>
                <a href="#" class="box '.$category->slug.'-download">
                    <div class="description">
                        <h3 class="text-uppercase">
                            Where to buy
                        </h3>
                        <p>
                            Consectetur adipiscing elit, sed do eiusmod
                            tempor incidid unt
                        </p>
                    </div>
                </a>
            </div>
        ';

        $content = PageContent::createPageContent($body);
        PageCustomField::createCustomField($key, $name, null, $content->id, $category->id);

        
    }
}
