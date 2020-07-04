<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Leaderboard;
use App\LeaderboardData;
use App\LeaderboardHistory;
use App\LeaderboardMatchHistory;
use App\Match;
use App\MatchData;
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
        if ($player == null)
        {
            abort(404);
        }

        $game = $gameSlug == "red-alert" ? MatchData::RA_1vs1 : MatchData::TD_1vs1;
        $gameLogo = "";
        if ($game == MatchData::RA_1vs1)
        {
             $gameLogo = ViewHelper::getRARemasterLogo();
        }
        else
        {
             $gameLogo = ViewHelper::getTDRemasterLogo();
        }

        $playerData = LeaderboardData::findPlayerData($player->id);
        $gameName = Constants::getTwitchGameBySlug($gameSlug);
        $leaderboard = Leaderboard::where("type", $game)->first();

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "matches" => $player->matches(),
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
        $pageNumber = $request->page == null ? 0: $request->page;
        $gameLogo = "";
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
    
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
                $data = $leaderboardRA->dataPaginated("leaderboardTD_1vs1".$pageNumber, $searchRequest, $paginate=200, $limit=400);
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
                "pageRanks" => $ranks
            ]
        );
    }

    private function getRankTypes($pageNumber)
    {
        return [];
    }

    public function getTopTDLeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        return $leaderboard->history();
    }
}