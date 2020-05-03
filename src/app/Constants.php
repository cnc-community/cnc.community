<?php 

namespace App;

class Constants
{
    public static function getCacheSeconds()
    {
        return config('app.cache_period');
    }
}