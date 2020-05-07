<?php 

namespace App;

class Constants
{
    public static function remastersAppId(): int
    {
        return 1213210;
    }

    public static function getCacheSeconds()
    {
        return config('app.cache_period');
    }
}