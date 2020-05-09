<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const CATEGORY_FUNNY = "Funny/Cool";
    
    protected $table = 'categories';
}
