<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function __construct()
    {
        
    }

    public function bladeTemplate()
    {
        $template = PageTemplate::find($this->template_id);
        if ($template == null) return null;
        return $template->blade_name;
    }

    public function url()
    {
        return "/" . $this->slug_category . "/" . $this->slug;
    }
}
