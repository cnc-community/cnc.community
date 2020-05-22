<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const CATEGORY_FUNNY = "Funny/Cool";
    public const CATEGORY_REMASTERS = "Command & Conquer Remastered News";
    
    protected $table = 'categories';
}
