<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function __construct()
    {
        
    }

    public function url()
    {
        return $this->slug_category . "/" . $this->slug;
    }
}
