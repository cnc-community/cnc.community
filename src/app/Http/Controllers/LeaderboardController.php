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
        $pageNumber = $request->page == null ? 1: $request->page;
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $gameLogo = ViewHelper::getRemasterLogoBySlug($gameSlug);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        $ranks = ViewHelper::getLeaderboardRanksByPageNumber($pageNumber);
        
        $cacheKey = $matchType . $pageNumber;
        
        $date = LeaderboardHelper::getCarbonDateFromQueryString($request->season);
        $data = Leaderboard::dataPaginated($cacheKey, $date, $matchType, $searchRequest, $paginate=200, $limit=200);

        $leaderboardHistory = Leaderboard::getHistoryByDateAndMatchType($date, $matchType);
        $stats = Leaderboard::stats($matchType, $leaderboardHistory->id);
        $stats["steamInGameCount"] = $this->steamHelper->getSteamPlayerCount(Constants::remastersAppId());

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
                "season" => $request->season,
                "stats" => $stats
            ]
        );
    }

    /**
     * Leaderboard Profiles
     */
    public function getPlayerLeaderboardProfile(Request $request, $gameSlug, $playerId)
    {
        $pageNumber = $request->page;
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        
        $player = MatchPlayer::find($playerId);
        if ($player == null)
        {
            abort(404);
        }

        $date = LeaderboardHelper::getCarbonDateFromQueryString($request->season);
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $gameLogo = ViewHelper::getRemasterLogoBySlug($gameSlug);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);

        $leaderboardHistory = Leaderboard::getHistoryByDateAndMatchType($date, $matchType);
        if ($leaderboardHistory == null)
        {
            abort(404);
        }   

        $showWebView = $request->showWebView;
        $webViewUrl = url("/api/leaderboard/". $gameSlug . "/player/". $playerId ."/webview/config");

        $playerData = LeaderboardData::findPlayerData($player->id, $leaderboardHistory->id);
        $matches = $player->matches($matchType, $pageNumber, $searchRequest, $leaderboardHistory->id);
        $gamesLast24Hours = $player->playerGames24Hours($matchType, $leaderboardHistory->id);

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "matches" => $matches->appends(request()->query()),
                "player" => $player,
                "playerData" => $playerData,
                "gameSlug" => $gameSlug,
                "gameName" => $gameName,
                "gameLogo" => $gameLogo,
                "leaderboardHistory" => $leaderboardHistory,
                "searchRequest" => $searchRequest,
                "showWebView" => $showWebView,
                "webViewUrl" => $webViewUrl,
                "gamesLast24Hours" => $gamesLast24Hours
            ]
        );
    }
}