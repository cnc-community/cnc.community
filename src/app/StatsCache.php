<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatsCache extends Model
{
    protected $table = 'stats_cache';

    protected $fillable = [
        'key', 'value', 'expires_at',
    ];

    public static function saveCache($key, $data, $ttl = 60)
    {
        $expiresAt = Carbon::now()->addMinutes($ttl);

        // Serialize data to store it as a text
        // $serializedData = serialize($data);
        $savedData = json_encode($data);

        StatsCache::where("key", "=", $key)->delete();

        // Update or create cache entry
        StatsCache::updateOrCreate(
            ['key' => $key],
            ['value' => $savedData, 'expires_at' => $expiresAt]
        );
    }

    public static function getCache($key)
    {
        $cacheEntry = StatsCache::where('key', $key)
            ->first();

        if ($cacheEntry)
        {
            // Unserialize the data to its original form
            return json_decode($cacheEntry->value, true);
        }

        return null; // Or handle cache miss accordingly
    }
}
