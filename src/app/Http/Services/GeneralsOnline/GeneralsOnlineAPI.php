<?php

namespace App\Http\Services\GeneralsOnline;

use App\Constants;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeneralsOnlineAPI
{
    private $_apiUrl;
    private $_apiKey;

    public function __construct()
    {
        $this->_apiUrl = config('app.generals_online_api_url');
        $this->_apiKey = config('app.generals_online_api_key');
    }

    public function getOnlineCount()
    {
        return Cache::remember('GeneralsOnlineAPI.getOnlineCount', 450, function ()
        {
            try 
            {
                $response = Http::withHeaders([
                    'X-API-Key' => $this->_apiKey,
                    'Accept' => 'application/json',
                ])->get($this->_apiUrl);

                if ($response->successful())
                {
                    return $this->getPlayerCountFromResponse($response->json());
                }
                
                Log::error('GeneralsOnlineAPI failed: ' . $response->status());
                return 0;
            }
            catch(Exception $exception)
            {
                Log::error('GeneralsOnlineAPI exception: ' . $exception->getMessage());
                return 0;
            }
        });
    }

    private function getPlayerCountFromResponse($data)
    {
        // The API returns an object with an 'active_users' array
        // We need to count the active_users array
        if (isset($data['active_users']) && is_array($data['active_users']))
        {
            return count($data['active_users']);
        }
        
        return 0;
    }
}
