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
    private $_allSeasonLeaderboardUrls = "http://8bit2coordlb1-339611218.us-east-1.elb.amazonaws.com:6530/Coordinator/webresources/com.petroglyph.coord.leaderboard.list.query/";

    private const NINEBIT_ARMIES_CACHE = "9bitarmies.cache";
    private const CACHE_TIME_SECONDS = 900; // Time we cache the leaderboard requests

    public function __construct()
    {
    }

    public function getLeaderboard()
    {
        $seasons = $this->getLatestSeason();
        $latestLadderBoardName = $seasons["9bitarmies"];

        return Cache::remember(NineBitArmiesAPI::NINEBIT_ARMIES_CACHE, NineBitArmiesAPI::CACHE_TIME_SECONDS, function () use ($latestLadderBoardName)
        {
            $data = $this->sendLeaderboardRequest($latestLadderBoardName, 200, 0);
            $data = json_decode(json_encode($data["ranks"]));

            return $data;
        });
        return [];
    }

    public function getLatestSeason()
    {
        $client = new Client();
        $response = $client->request('GET', $this->_allSeasonLeaderboardUrls, [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json;charset=utf-8'
            ]
        ]);

        if ($response->getStatusCode() == 200)
        {
            $data = json_decode($response->getBody(), true);
            $leaderboards = $data['leaderboards'];

            // Initialize arrays to store the latest expiration times for each mmrtype
            $latestSeasons = [
                1 => ['season' => null, 'expirationtime' => '0000-00-00T00:00:00'],
                2 => ['season' => null, 'expirationtime' => '0000-00-00T00:00:00']
            ];

            // Iterate through the leaderboards and find the latest season for each mmrtype
            foreach ($leaderboards as $leaderboard)
            {
                if (isset($leaderboard['mmrtype']) && isset($leaderboard['expirationtime']))
                {
                    $mmrtype = $leaderboard['mmrtype'];
                    $expirationtime = $leaderboard['expirationtime'];
                    $season = $leaderboard['boardname'];

                    // Check if this expirationtime is later than the currently stored one
                    if ($expirationtime > $latestSeasons[$mmrtype]['expirationtime'])
                    {
                        $latestSeasons[$mmrtype] = ['season' => $season, 'expirationtime' => $expirationtime];
                    }
                }
            }

            // Return only the latest seasons
            return [
                "9bitarmies" => $latestSeasons[1]['season'],
            ];
        }
        else
        {
            Log::error("Failed to retrieve data. Status code: " . $response->getStatusCode());
            return null;
        }
    }

    public function sendLeaderboardRequest(string $boardName, int $limit = 200, int $offset = 0)
    {
        try
        {
            $request = json_encode(
                array(
                    "leaderboardQueryV2" => [
                        "boardName" => $boardName,
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
                return [];
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
