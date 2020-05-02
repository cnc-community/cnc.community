<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageCustomField extends Model
{
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
        return PageCustomField::where("page_id", $pageId)->get();
    }

    public static function createCustomField($key, $name, $pageId, $contentId, $position)
    {
        $field = new PageCustomField();
        $field->key = $key;
        $field->name = $name;
        $field->page_id = $pageId;
        $field->content_id = $contentId;
        $field->position = $position;
        $field->save();
    }
}
