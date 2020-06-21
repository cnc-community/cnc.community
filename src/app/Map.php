<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'maps';
}