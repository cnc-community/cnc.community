<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Leaderboard;
use App\LeaderboardData;
use App\Match;
use App\MatchData;
use App\MatchPlayer;
use App\ViewHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\Caster\ConstStub;

class LeaderboardController extends Controller
{
    private $petroglyphAPIService;

    public function __construct()
    {
        $this->petroglyphAPIService = new PetroglyphAPIService();
    }

    public function runGetMatchTasks()
    {
        $this->petroglyphAPIService->runGetMatchTasks();
    }
    
    public function runGetLeaderboardTasks()
    {
        $this->petroglyphAPIService->runGetLeaderboardTasks();
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

    public function getPlayerLeaderboardProfile($gameSlug, $playerId)
    {
        $player = MatchPlayer::find($playerId);
        if ($player == null)
        {
            abort(404);
        }

        $matches = Match::getPlayerMatches($player);
        $playerData = LeaderboardData::findPlayerData($player->id);
        $gameName = Constants::getTwitchGameBySlug($gameSlug);
        $gameLogo = ViewHelper::getGameLogoPathByName($gameSlug);

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "matches" => $matches,
                "player" => $player,
                "playerData" => $playerData,
                "gameSlug" => $gameSlug,
                "gameName" => $gameName,
                "gameLogo" => $gameLogo
            ]
        );
    }

    public function getLeaderboardListingsByGame(Request $request, $gameSlug)
    {
        $pageNumber = $request->page == null ? 0: $request->page;
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        $gameLogo = "";
        $gameName = Constants::getRemasterGameBySlug($gameSlug);
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);

        $data = [];

        switch($gameSlug)
        {
            case "tiberian-dawn":
                $cacheKey = "td".$pageNumber;
                $leaderboardTD = Leaderboard::where("type", "td_1vs1")->first();
                $gameLogo = ViewHelper::getTDRemasterLogo();
                $top15Data = $leaderboardTD->data($cacheKey, $searchRequest, $limit=15, $offset=0 );
                $data = $leaderboardTD->dataPaginated($cacheKey, $searchRequest, $paginate=50, $limit=400);
                break;

            case "red-alert":
                $cacheKey = "ra".$pageNumber;
                $leaderboardRA = Leaderboard::where("type", "ra_1vs1")->first();
                $gameLogo = ViewHelper::getRARemasterLogo();
                $top15Data = $leaderboardRA->data($cacheKey, $searchRequest, $limit=15, $offset=0 );
                $data = $leaderboardRA->dataPaginated($cacheKey, $searchRequest, $paginate=50, $limit=400);
                break;

            default: 
                abort(404);
        }

        return view('pages.remasters.leaderboard.detail', 
            [
                "top15Data" => $top15Data,
                "data" => $data,
                "gameLogo" => $gameLogo,
                "gameName" => $gameName,
                "heroVideo" => $heroVideo,
                "gameSlug" => $gameSlug,
                "pageNumber" => $pageNumber,
                "searchRequest" => $searchRequest
            ]
        );
    }

    public function getTopTDLeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        return $leaderboard->history();
    }
}