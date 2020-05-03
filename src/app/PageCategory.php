<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    protected $table = 'page_category';

    public function __construct()
    {
        
    }

    public function bladeTemplate()
    {
        $template = PageTemplate::find($this->template_id);
        if ($template == null) return null;
        return $template->blade_name;
    }
}
