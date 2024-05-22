<?php

namespace App\Http\Services\Petroglyph;

use App\Constants;
use App\Leaderboard;
use App\LeaderboardHistory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NineBitArmiesAPI
{
    private $_apiUrl = "http://8Bit2CoordLB1-339611218.us-east-1.elb.amazonaws.com:6530/Coordinator/webresources/com.petroglyph.coord.leaderboard.queryv2/";

    public function __construct()
    {
    }

    public function getLeaderboard($limit = 200, $offset = 0)
    {
        // https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/com.petroglyph.coord.leaderboard.list.query/
        // R1V1_MMR_BOARD is the RedAlert leaderboard,
        // 1V1_MMR_BOARD is the TiberianDawn one.
        $request = json_encode(
            array(
                "leaderboardQueryV2" => [
                    "boardName" => "1V1_MMR_BOARD",
                    "offset" => $offset,
                    "limit" => $limit
                ]
            )
        );

        $client = new Client();

        $r = $client->request('PUT', $this->_apiUrl, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json;charset=utf-8'
            ],
            'body' => $request
        ]);

        if ($r->getStatusCode() == 200)
        {
            return json_decode($r->getBody(), true);
        }
        else
        {
            dd("Bad request", $r->getStatusCode());
        }

        return [];
    }
}
