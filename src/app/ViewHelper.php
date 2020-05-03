<?php

namespace App;

use App\PageCustomField;

class ViewHelper
{
    public static function getCustomFieldContents($pageId, $key)
    {
        $customField = PageCustomField::getCustomFieldByPageAndKey($pageId, $key);
        if ($customField)
        {
            return $customField->getContent();
        }
        return null;
    }

    public static function getCategoryCustomFieldContents($categoryId, $key)
    {
        $customField = PageCustomField::getCustomFieldsByPageCategoryIdAndKey($categoryId, $key);
        if ($customField)
        {
            return $customField->getContent();
        }
        return null;
    }
}