<?php

namespace App\Http\Services\Petroglyph;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RemastersAPI
{
    private $_allSeasonLeaderboardUrls = "https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/com.petroglyph.coord.leaderboard.list.query/";
    private $_seasonLeaderboardUrl = "https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/com.petroglyph.coord.leaderboard.queryv2/";
    private $_recentMatchesUrl = "https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/com.petroglyph.coord.matches.recent/";

    private const RA_CACHE = "redalert.cache";
    private const TD_CACHE = "tiberiandawn.cache";
    private const CACHE_TIME_SECONDS = 900; // Time we cache the leaderboard requests

    public function __construct()
    {
    }

    public function getRALeaderboard()
    {
        $seasons = $this->getLatestSeason();
        $raSeasonBoardName = $seasons["RedAlert"];
        return Cache::remember(RemastersAPI::RA_CACHE, RemastersAPI::CACHE_TIME_SECONDS, function () use ($raSeasonBoardName)
        {
            $data = $this->sendLeaderboardRequest($raSeasonBoardName, 200, 0);
            $data = json_decode(json_encode($data["ranks"]));

            return $data;
        });
        return [];
    }

    public function getTDLeaderboard()
    {
        $seasons = $this->getLatestSeason();
        $tdSeasonBoardName = $seasons["TiberianDawn"];
        return Cache::remember(RemastersAPI::TD_CACHE, RemastersAPI::CACHE_TIME_SECONDS, function () use ($tdSeasonBoardName)
        {
            $data = $this->sendLeaderboardRequest($tdSeasonBoardName, 200, 0);
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
                // mmrtype 1 = Tiberian Dawn
                // mmrtype 2 = Red Alert 
                "TiberianDawn" => $latestSeasons[1]['season'],
                "RedAlert" => $latestSeasons[2]['season']
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

            $r = $client->request('PUT', $this->_seasonLeaderboardUrl, [
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
                Log::info("Remasters API ** $r->getStatusCode()");
            }
        }
        catch (Exception $ex)
        {
            Log::info("Remasters API ** " . $ex->getMessage());
        }
        return [];
    }


    public function fetchNamesFromRecentGames()
    {
        $client = new Client();
        $offset = 0;
        $limit = 200;
        $lookupTable = [];
        $totalMatches = 4000; // Hardcoded to X recent games, otherwise we're iterating through 5+ million games.  

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

                Log::info("RemastersAPI ** Offset: $offset");
            }
            else
            {
                Log::info("RemastersAPI ** Bad request", $response->getStatusCode());
            }
        } while ($offset < $totalMatches);

        return $lookupTable;
    }
}
