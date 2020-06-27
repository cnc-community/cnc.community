<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $connection= 'mysql';
    protected $table = 'page_content';

    public function __construct()
    {
        
    }

    public static function createPageContent($body)
    {
        $content = new PageContent();
        $content->body = $body;
        $content->save();
        return $content;
    }

    public static function savePageContent($id, $body)
    {
        $content = PageContent::find($id);
        $content->body = $body;
        $content->save();
    }
}
