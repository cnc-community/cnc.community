<?php

namespace App\Http\Services\Petroglyph;

use App\Constants;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PetroglyphAPI
{
    public const RECENT_MATCHES_URL = "com.petroglyph.coord.matches.recent/";
    public const LEADERBOARD_URL = "com.petroglyph.coord.leaderboard.queryv2/";

    private $_apiUrl = "https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/";

    public function __construct()
    {
    }

    public function getTDLeaderboard($limit, $offset)
    {
        // 1V1_MMR_BOARD is the TiberianDawn one.
        return $this->getLeaderboard("1V1_MMR_BOARD", $limit, $offset);
    }

    public function getRALeaderboard($limit, $offset)
    {
        // R1V1_MMR_BOARD is the RedAlert leaderboard,
        return $this->getLeaderboard("R1V1_MMR_BOARD", $limit, $offset);
    }

    private function getLeaderboard($type, $limit, $offset)
    {
        // R1V1_MMR_BOARD is the RedAlert leaderboard,
        // 1V1_MMR_BOARD is the TiberianDawn one.
        $request = json_encode(
            array(
            "leaderboardQueryV2" => [
                "boardName" => $type,
                "offset" => $offset,
                "limit" => $limit
            ])
        );
        
        $client = new Client();
        
        $url = $this->_apiUrl . PetroglyphAPI::LEADERBOARD_URL;

        $r = $client->request('PUT',$url, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json;charset=utf-8'
            ],
            'body' => $request
            ]);
            
        Log::debug("Requested ".$url);

        return json_decode($r->getBody(), true);
    }

    public function getMatches($limit, $offset)
    {
        $client = new Client();
        
        $url = $this->_apiUrl . PetroglyphAPI::RECENT_MATCHES_URL . "?limit=".$limit . "&offset=". $offset;

        $r = $client->request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json;charset=utf-8'
            ]
            ]);
            
        $response = json_decode($r->getBody(), true);

        Log::debug("Requested ".$url);

        return $response;
    }
}
