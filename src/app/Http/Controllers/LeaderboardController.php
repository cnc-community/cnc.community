<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Petroglyph\PetroglyphAPIService;
use App\Leaderboard;
use App\LeaderboardData;
use App\Match;
use App\MatchData;
use App\MatchPlayer;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    private $petroglyphAPIService;

    public function __construct()
    {
        $this->petroglyphAPIService = new PetroglyphAPIService();
    }

    public function runTasks()
    {
        $this->petroglyphAPIService->runTasks();
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

        return view('pages.remasters.leaderboard.player-detail', 
            [
                "matches" => $matches,
                "player" => $player,
                "playerData" => $playerData
            ]
        );
    }

    public function getLeaderboardListingsByGame(Request $request, $game)
    {
        $pageNumber = $request->page == null ? 0: $request->page;
        $heroVideo = Constants::getVideoWithPoster("command-and-conquer-remastered");
        $gameName = "";
        $gameLogo = "";
        $data = [];

        switch($game)
        {
            case "tiberian-dawn":
                $cacheKey = "td".$pageNumber;
                $leaderboardTD = Leaderboard::where("type", "td_1vs1")->first();
                $top15Data = $leaderboardTD->data($cacheKey,15,0);
                $data = $leaderboardTD->dataPaginated($cacheKey,50, 200);
                $gameName = "Tiberian Dawn";
                $gameLogo = "/assets/images/logos/tiberian-dawn-remastered.png";
                break;

            case "red-alert":
                $cacheKey = "ra".$pageNumber;
                $leaderboardRA = Leaderboard::where("type", "ra_1vs1")->first();
                $top15Data = $leaderboardRA->data($cacheKey,15,0);
                $data = $leaderboardRA->dataPaginated($cacheKey,50, 200);
                $gameName = "Red Alert";
                $gameLogo = "/assets/images/logos/red-alert-remastered.png";
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
                "gameSlug" => $game,
                "pageNumber" => $pageNumber
            ]
        );
    }

    public function getTopTDLeadeboard1vs1()
    {
        $leaderboard = Leaderboard::where("type", "td_1vs1")->first();
        return $leaderboard->history();
    }
}