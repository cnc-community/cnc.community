<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\CNCOnlineCount;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Http\Services\SteamHelper;
use App\Leaderboard;
use App\LeaderboardData;
use App\LeaderboardHelper;
use App\LeaderboardHistory;
use App\LeaderboardMatchHistory;
use App\Match;
use App\MatchPlayer;
use App\ViewHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class LeaderboardController extends Controller
{
    private $petroglyphAPIService;
    private $steamHelper;

    public function __construct()
    {
        $this->petroglyphAPIService = new PetroglyphAPIService();
        $this->steamHelper = new SteamHelper();
        $this->cncOnlineCount = new CNCOnlineCount();

        View::share('totalOnline', $this->cncOnlineCount->getTotal());
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

    /**
     * Leaderboard Listings by Game Slug
     */
    public function getLeaderboardListingsByGame(Request $request, $gameSlug)
    {
        $pageNumber = filter_var($request->page == null ? 1: $request->page, FILTER_SANITIZE_STRING);
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        $season = filter_var($request->season, FILTER_SANITIZE_STRING);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        
        $leaderboardHistory = Leaderboard::getLeaderboardBySeason($matchType, $season);
        if ($leaderboardHistory == null)
        {
            abort(404);
        }

        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $gameLogo = ViewHelper::getRemasterLogoBySlug($gameSlug);
        $ranks = ViewHelper::getLeaderboardRanksByPageNumber($pageNumber);
        
        $cacheKey = "LeaderboardController.getLeaderboardListingsByGame".$matchType.$pageNumber.$season.$searchRequest;
        $data = Leaderboard::dataPaginated(
            $cacheKey, 
            $leaderboardHistory->id, 
            $matchType, 
            $searchRequest, 
            $paginate=200, 
            $limit=200
        );

        $stats = Leaderboard::stats($matchType, $leaderboardHistory->id);
        $stats["steamInGameCount"] = $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId());
        $activeSeason = $leaderboardHistory->isActiveSeason();

        return view('pages.remasters.leaderboard.detail', 
            [
                "gameLogo" => $gameLogo,
                "gameName" => $gameName,
                "gameSlug" => $gameSlug,
                "pageNumber" => $pageNumber,
                "pageRanks" => $ranks,
                "searchRequest" => $searchRequest,
                "season" => $season,
                "stats" => $stats,
                "activeSeason" => $activeSeason,
                "data" => $data->appends(["season" => $season, "search" => $searchRequest])
            ]
        );
    }

    /**
     * Leaderboard Profiles
     */
    public function getPlayerLeaderboardProfile(Request $request, $gameSlug, $playerId)
    {
        $pageNumber = filter_var($request->page, FILTER_SANITIZE_STRING);
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        $season = filter_var($request->season, FILTER_SANITIZE_STRING);
        $showWebView = filter_var($request->showWebView, FILTER_SANITIZE_STRING);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);

        $leaderboardHistory = Leaderboard::getLeaderboardBySeason($matchType, $season);
        if ($leaderboardHistory == null)
        {
            abort(404);
        }

        $player = MatchPlayer::find($playerId);
        if ($player == null)
        {
            abort(404);
        }

        $playerData = LeaderboardData::findPlayerData($player->id, $leaderboardHistory->id);
        $matches = $player->matches($matchType, $pageNumber, $searchRequest, $leaderboardHistory->id);
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $gameLogo = ViewHelper::getRemasterLogoBySlug($gameSlug);
        $webViewUrl = url("/api/leaderboard/". $gameSlug . "/player/". $playerId ."/webview/config");
        $gamesLast24Hours = $player->playerGames24Hours($matchType, $leaderboardHistory->id);
        $winStreak = $player->playerWinStreak($matchType, $leaderboardHistory->id);
        $activeSeason = $leaderboardHistory->isActiveSeason();

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "gameLogo" => $gameLogo,
                "gameName" => $gameName,
                "gameSlug" => $gameSlug,
                "pageNumber" => $pageNumber,
                "searchRequest" => $searchRequest,
                "season" => $season,
                "gamesLast24Hours" => $gamesLast24Hours,
                "winStreak" => $winStreak,
                "matches" => $matches->appends(["season" => $season, "search" => $searchRequest]),
                "player" => $player,
                "playerData" => $playerData,
                "leaderboardHistory" => $leaderboardHistory,
                "showWebView" => $showWebView,
                "webViewUrl" => $webViewUrl,
                "activeSeason" => $activeSeason,
                "matchType" => $matchType
            ]
        );
    }
}