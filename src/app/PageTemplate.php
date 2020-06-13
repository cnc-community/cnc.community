<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    protected $connection= 'mysql';
    protected $table = 'page_template';

    public function __construct()
    {
        
    }
}
