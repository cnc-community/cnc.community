<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageCustomField extends Model
{
    protected $connection= 'mysql';
    protected $table = 'page_custom_fields';

    public function __construct()
    {
        
    }

    public function getContent()
    {
        $pageContent = PageContent::where("id", $this->id)->first();
        if ($pageContent)
        {
            return $pageContent->body;
        }
        return null;
    }

    public static function updateContent($customFieldId, $content)
    {
        return PageContent::savePageContent($customFieldId, $content);
    }

    public static function getCustomFieldByPageAndKey($pageId, $key)
    {
        return PageCustomField::where("page_id", $pageId)->where("key", $key)->first();
    }

    public static function getCustomFieldsByPageId($pageId)
    {
        return PageCustomField::where("page_id", $pageId)->where("category_id", NULL)->get();
    }

    /**
     * Get custom field by category id and key
     */
    public static function getCustomFieldsByPageCategoryIdAndKey($pageCategoryId, $key)
    {
        return PageCustomField::where("category_id", $pageCategoryId)->where("key", $key)->first();
    }

    /**
     * Get all custom fields by category id
     */
    public static function getCustomFieldsByPageCategoryId($pageCategoryId)
    {
        return PageCustomField::where("category_id", $pageCategoryId)->where("page_id", NULL)->get();
    }

    public static function createCustomField($key, $name, $pageId, $contentId, $pageCategoryId)
    {
        $field = new PageCustomField();
        $field->key = $key;
        $field->name = $name;
        $field->page_id = $pageId;
        $field->content_id = $contentId;
        $field->category_id = $pageCategoryId;
        $field->save();
    }
}
