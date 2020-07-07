<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Leaderboard;
use App\LeaderboardData;
use App\LeaderboardHistory;
use App\LeaderboardMatchHistory;
use App\Match;
use App\MatchPlayer;
use App\ViewHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeaderboardController extends Controller
{
    private $petroglyphAPIService;

    public function __construct()
    {
        $this->petroglyphAPIService = new PetroglyphAPIService();
    }

    public function runMatchesTask()
    {
        $this->petroglyphAPIService->runMatchesTask();
    }
    
    public function runRALeaderboardTasks()
    {
        $this->petroglyphAPIService->runRALeaderboardTasks();
    }

    public function runTDLeaderboardTasks()
    {
        $this->petroglyphAPIService->runTDLeaderboardTasks();
    }

    public function getLeaderboardListings()
    {
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        
        return view('pages.remasters.leaderboard.listings', 
            [
                "heroVideo" => $heroVideo
            ]
        );
    }

    public function getPlayerLeaderboardProfile(Request $request, $gameSlug, $playerId)
    {
        $player = MatchPlayer::find($playerId);
        $page = $request->page;

        if ($player == null)
        {
            abort(404);
        }
        
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        
        $gameLogo = "";
        if ($matchType == Match::RA_1vs1)
        {
            $gameLogo = ViewHelper::getRARemasterLogo();
            $leaderboard = Leaderboard::where("type", "ra_1vs1")->first();
        }
        else
        {
             $gameLogo = ViewHelper::getTDRemasterLogo();
             $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        }

        $playerData = LeaderboardData::findPlayerData($player->id);
        $gameName = Constants::getTwitchGameBySlug($gameSlug);
        $matches = $player->matches($matchType, $page);

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "matches" => $matches,
                "player" => $player,
                "playerData" => $playerData,
                "gameSlug" => $gameSlug,
                "gameName" => $gameName,
                "gameLogo" => $gameLogo,
                "leaderboardHistory" => $leaderboard->history()
            ]
        );
    }

    public function getLeaderboardListingsByGame(Request $request, $gameSlug)
    {
        $pageNumber = $request->page == null ? 1: $request->page;
        $gameLogo = "";
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        
        // $longestMatches = Match::quickStats($matchType);

        switch($gameSlug)
        {
            case "tiberian-dawn":
                $gameLogo = ViewHelper::getTDRemasterLogo();
                $leaderboardTD = Leaderboard::where("type", "td_1vs1")->first();
                $data = $leaderboardTD->dataPaginated("leaderboardTD_1vs1".$pageNumber, $searchRequest, $paginate=200, $limit=400);
            break;

            case "red-alert":
                $gameLogo = ViewHelper::getRARemasterLogo();
                $leaderboardRA = Leaderboard::where("type", "ra_1vs1")->first();
                $data = $leaderboardRA->dataPaginated("leaderboardRA_1vs1".$pageNumber, $searchRequest, $paginate=200, $limit=400);
            break;

            default:
                abort(404);
        }

        $ranks = $this->getRankTypes($pageNumber);

        return view('pages.remasters.leaderboard.detail', 
            [
                "gameLogo" => $gameLogo,
                "gameName" => $gameName,
                "gameSlug" => $gameSlug,
                "pageNumber" => $pageNumber,
                "searchRequest" => $searchRequest,
                "data" => $data,
                "pageRanks" => $ranks,
                "searchRequest" => $searchRequest,
                // "longestMatches" => $longestMatches
            ]
        );
    }

    private function getRankTypes($pageNumber)
    {
        switch($pageNumber)
        {
            case 5:
                return [1000];

            case 4:
            case 3:
                return [600];

            case 2:
                return [400];
            
            case 1:
            default:
                return [16, 200];
        }

        return [];
    }

    public function getTopTDLeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        return $leaderboard->history();
    }
}