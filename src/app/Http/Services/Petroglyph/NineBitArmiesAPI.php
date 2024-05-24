<?php

namespace App\Http\Services\Petroglyph;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NineBitArmiesAPI
{
    private $_apiUrl = "http://8Bit2CoordLB1-339611218.us-east-1.elb.amazonaws.com:6530/Coordinator/webresources/com.petroglyph.coord.leaderboard.queryv2/";
    private $_recentMatchesUrl = "http://8bit2coordlb1-339611218.us-east-1.elb.amazonaws.com:6530/Coordinator/webresources/com.petroglyph.coord.matches.recent";

    private const NINEBIT_ARMIES_CACHE = "9bitarmies.cache";
    private const CACHE_TIME_SECONDS = 900; // Time we cache the leaderboard requests

    public function __construct()
    {
    }

    public function getLeaderboard()
    {
        return Cache::remember(NineBitArmiesAPI::NINEBIT_ARMIES_CACHE, NineBitArmiesAPI::CACHE_TIME_SECONDS, function ()
        {
            $data = $this->sendLeaderboardRequest(200, 0);
            $data = json_decode(json_encode($data["ranks"]));

            return $data;
        });
        return [];
    }

    private function sendLeaderboardRequest($limit = 200, $offset = 0)
    {
        try
        {
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
        }
        catch (Exception $ex)
        {
        }
        return [];
    }

    public function fetchNamesFromRecentGames()
    {
        $client = new Client();
        $offset = 0;
        $limit = 200;
        $lookupTable = [];
        $totalMatches = null;

        do
        {
            $response = $client->request('GET', $this->_recentMatchesUrl, [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json;charset=utf-8'
                ]
            ]);

            if ($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody(), true);

                if ($offset == 0)
                {
                    $totalMatches = $data['totalmatches'];
                }

                $matches = $data['matches'];

                if (empty($matches))
                {
                    break;
                }

                foreach ($matches as $match)
                {
                    foreach ($match['players'] as $index => $steamid)
                    {
                        $lookupTable[$steamid] = $match['names'][$index];
                    }
                }

                $offset += $limit;

                Log::info("NineBitArmiesAPI ** Offset: $offset");
            }
            else
            {
                Log::info("NineBitArmiesAPI ** " . $response->getStatusCode());
            }
        } while ($offset < $totalMatches);

        return $lookupTable;
    }
}
