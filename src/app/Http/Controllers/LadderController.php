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

    /**
     * Extract the integer at the end of a string. Usually in format 
     *
     * @param string $seasonString
     * @return int|null
     */
    public function extractSeasonNumber($seasonString)
    {
        if (preg_match('/_(\d+)$/', $seasonString, $matches)) {
            return (int) $matches[1];
        }
        return null;
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
        $latestSeasons = $this->remastersAPI->getLatestSeason();
        $latestSeason = $game == "red-alert" ? $this->extractSeasonNumber($latestSeasons['RedAlert']) : $this->extractSeasonNumber($latestSeasons['TiberianDawn']);
        
        // Use the season from the URL if provided, otherwise default to the latest season
        $currentSeason = $season ?? $latestSeason;

        return view(
            'pages.remasters.ladder.listings',
            [
                'data' => $data,
                'heroVideo' => $heroVideo,
                'abbrev' => $game,
                'steamLookup' => $steamLookup,
                'gameName' => $gameName,
                'latestSeason' => $latestSeason,
                'currentSelectedSeason' => $currentSeason
            ]
        );
    }

    public function getSpecificSeasonLeaderboard(Request $request, $season, $game)
    {
        # S1-9 need prefixing to match formatting 01, 02, 03 for table names
        $seasonBoardName = ($game === 'tiberian-dawn' ? '1V1_BOARD_S_' : 'R1V1_BOARD_S_') . str_pad($season, 2, '0', STR_PAD_LEFT);

        $data = $this->remastersAPI->sendLeaderboardRequest($seasonBoardName, 200, 0);
        $data = json_decode(json_encode($data["ranks"]));

        $steamIds = [];
        foreach ($data as $d)
        {
            $steamIds[] = $d->steamids[0];
        }

        $steamLookup = $this->petroglyphSteamProfileService->getSteamProfilesByIds($steamIds);
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        $gameName = $game == "red-alert" ? "Red Alert Remastered" : "Tiberian Dawn Remastered";
        $latestSeasons = $this->remastersAPI->getLatestSeason();
        $latestSeason = $game == "red-alert" ? $this->extractSeasonNumber($latestSeasons['RedAlert']) : $this->extractSeasonNumber($latestSeasons['TiberianDawn']);
        
        // Use the season from the URL if provided, otherwise default to the latest season
        $currentSeason = $season ?? $latestSeason;

        return view(
            'pages.remasters.ladder.listings',
            [
                'data' => $data,
                'steamLookup' => $steamLookup,
                'gameName' => $gameName,
                'heroVideo' => $heroVideo,
                'abbrev' => $game,
                'latestSeason' => $latestSeason,
                'currentSelectedSeason' => $currentSeason
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
        $latestSeason = extractSeasonNumber($this->remastersAPI->getLatestSeason());
        $steamIds = [];

        // Sync Red Alert leaderboard (defaulting to 18 in case it has issues getting latest season)
        $latestSeason = isset($latestSeasons['RedAlert']) ? extractSeasonNumber($latestSeasons['RedAlert']) : 18;
        $steamIds = array_merge($steamIds, $this->syncGameLeaderboard('R1V1_BOARD_S_', $latestSeason));

        // Sync Tiberian Dawn leaderboard (defaulting to 18 in case it has issues getting latest season)
        $latestSeason = isset($latestSeasons['TiberianDawn']) ? extractSeasonNumber($latestSeasons['TiberianDawn']) : 18;
        $steamIds = array_merge($steamIds, $this->syncGameLeaderboard('1V1_BOARD_S_', $latestSeason));

        // Sync from steam
        $this->petroglyphSteamProfileService->syncSteamProfiles($steamIds, Constants::remastersAppId());

        // Sync from recent games list
        $this->petroglyphSteamProfileService->syncRemastersFromRecentGames();
    }

    /**
     * Sync leaderboard data for a specific game
     * @param string $boardPrefix
     * @param int $latestSeason
     * @return array
     * @throws GuzzleException
     */
    private function syncGameLeaderboard($boardPrefix, $latestSeason)
    {
        $steamIds = [];

        for ($season = 1; $season <= $latestSeason; $season++) {
            $seasonBoardName = $boardPrefix . str_pad($season, 2, '0', STR_PAD_LEFT);
            $data = $this->remastersAPI->sendLeaderboardRequest($seasonBoardName, 200, 0);
            $data = json_decode(json_encode($data["ranks"]));

            foreach ($data as $d) {
                $steamIds[] = $d->steamids[0];
            }
        }

        return $steamIds;
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
