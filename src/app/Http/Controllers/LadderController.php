<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\EightBitArmiesAPI;
use App\Http\Services\Petroglyph\NineBitArmiesAPI;
use App\Http\Services\Petroglyph\PetroglyphSteamProfileService;
use App\Http\Services\Petroglyph\RemastersAPI;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class LadderController extends Controller
{
    private EightBitArmiesAPI $eightBitArmiesAPI;
    private NineBitArmiesAPI $nineBitArmiesAPI;
    private RemastersAPI $remastersAPI;
    private PetroglyphSteamProfileService $petroglyphSteamProfileService;

    public function __construct()
    {
        $this->eightBitArmiesAPI = new EightBitArmiesAPI();
        $this->nineBitArmiesAPI = new NineBitArmiesAPI();
        $this->remastersAPI = new RemastersAPI;
        $this->petroglyphSteamProfileService = new PetroglyphSteamProfileService();
    }

    public function getEightBitArmiesIndex(Request $request)
    {
        $data = $this->eightBitArmiesAPI->getLeaderboard();
        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        $steamLookup = $this->petroglyphSteamProfileService->getSteamProfilesByIds($steamIds);
        return view(
            'pages.8bitarmies.ladder.listings',
            [
                'data' => $data,
                'steamLookup' => $steamLookup,
                'gameName' => '8-Bit Armies: A Bit Too Far'
            ]
        );
    }

    public function getNineBitArmiesIndex(Request $request)
    {
        $data = $this->nineBitArmiesAPI->getLeaderboard();
        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        $steamLookup = $this->petroglyphSteamProfileService->getSteamProfilesByIds($steamIds);
        return view(
            'pages.9bitarmies.ladder.listings',
            [
                'data' => $data,
                'steamLookup' => $steamLookup,
                'gameName' => '9-Bit Armies: A Bit Too Far'
            ]
        );
    }

    public function getRemasteredIndex(Request $request, $game)
    {
        if ($game == "red-alert")
        {
            $data = $this->remastersAPI->getRALeaderboard();
        }
        else
        {
            $data = $this->remastersAPI->getTDLeaderboard();
        }

        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        $steamLookup = $this->petroglyphSteamProfileService->getSteamProfilesByIds($steamIds);
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        $gameName = $game == "red-alert" ? "Red Alert Remastered" : "Tiberian Dawn Remastered";

        return view(
            'pages.remasters.ladder.listings',
            [
                'data' => $data,
                'heroVideo' => $heroVideo,
                'abbrev' => $game,
                'steamLookup' => $steamLookup,
                'gameName' => $gameName
            ]
        );
    }

    public function getSpecificSeasonTDLeaderboard(Request $request, $season)
    {
        # S1-9 need prefixing to match formatting 01, 02, 03 for table names
        $tdSeasonBoardName = '1V1_BOARD_S_' . str_pad($season, 2, '0', STR_PAD_LEFT);

        $data = $this->remastersAPI->sendLeaderboardRequest($tdSeasonBoardName, 200, 0);
        $data = json_decode(json_encode($data["ranks"]));

        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        $steamLookup = $this->petroglyphSteamProfileService->getSteamProfilesByIds($steamIds);
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");

        return view(
            'pages.remasters.ladder.listings',
            [
                'data' => $data,
                'steamLookup' => $steamLookup,
                'gameName' => 'Tiberian Dawn',
                'heroVideo' => $heroVideo,
                'abbrev' => 'Tiberian Dawn Remastered'
            ]
        );
    }


    /**
     * Sync via cron task
     * @param mixed $steamIds 
     * @return never 
     * @throws GuzzleException 
     */
    public function syncRemasters()
    {
        $data = $this->remastersAPI->getRALeaderboard();
        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        // $data = $this->remastersAPI->getTDLeaderboard();
        // foreach ($data as $d)
        // {
        //     $steamIds[] = $d->steamids[0];
        // }

        // Sync Tiberian Dawn leaderboard for all seasons
        $latestSeason = 18; // Replace with logic to get the latest season dynamically if needed
        for ($season = 1; $season <= $latestSeason; $season++) {
            $tdSeasonBoardName = '1V1_BOARD_S_' . str_pad($season, 2, '0', STR_PAD_LEFT);
            $data = $this->remastersAPI->sendLeaderboardRequest($tdSeasonBoardName, 200, 0);
            $data = json_decode(json_encode($data["ranks"]));

            foreach ($data as $d)
            {
                $steamIds[] = $d->steamids[0];
            }
        }

        // Sync from steam
        $this->petroglyphSteamProfileService->syncSteamProfiles($steamIds, Constants::remastersAppId());
        // Sync from recent games list
        $this->petroglyphSteamProfileService->syncRemastersFromRecentGames();
    }

    /**
     * Sync via cron task
     * @param mixed $steamIds 
     * @return never 
     * @throws GuzzleException 
     */
    public function syncNineBitArmies()
    {
        $data = $this->nineBitArmiesAPI->getLeaderboard();
        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        // Sync from steam
        $this->petroglyphSteamProfileService->syncSteamProfiles($steamIds, Constants::nineBitArmiesAppId());
        // Sync from recent petro games list
        $this->petroglyphSteamProfileService->syncNineBitArmiesFromRecentGames();
    }
}
