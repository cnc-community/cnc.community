<?php 

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Services\Steam\SteamAPI;
use App\Http\Services\SteamHelper;
use App\Http\Services\SteamWorkShopItem;
use App\Http\Services\Twitch\TwitchStreamsAPI;
use App\Leaderboard;
use App\LeaderboardData;
use App\LeaderboardHelper;
use App\Match;
use App\MatchPlayer;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Http\Services\APILeaderboardProfile;
use App\Http\Services\CNCOnlineCount;
use App\Http\Services\CompetitionService;

class APIController extends Controller
{
    private $twitchStreamsAPI;
    private $steamAPI;
    private $petroglyphAPI;
    private $cncOnlineCount;
    private $competitionService;

    public function __construct()
    {
        $this->twitchStreamsAPI = new TwitchStreamsAPI();
        $this->steamAPI = new SteamAPI();
        $this->cncOnlineCount = new CNCOnlineCount();
        $this->competitionService = new CompetitionService();
    }

    public function recentGamesByMatchType(Request $request, $matchType)
    {
        $type = null;
        switch($matchType)
        {
            case "ra":
                $type = Match::RA_1vs1;
                break;
            case "td":
                $type = Match::TD_1vs1;
                break;
            case "all":
                $type = Match::RA_TD_FFG;
                break;
            default:
                $type = null;
        }
        
        if ($type == null)
        {
           return "Incorrect params";
        }

        $timeStart = filter_var($request->timeStart == null ? 1: $request->timeStart, FILTER_SANITIZE_STRING);
        $timeEnd = filter_var($request->timeEnd == null ? 1: $request->timeEnd, FILTER_SANITIZE_STRING);

        return $this->competitionService->getPlayersByMatchType($type, $timeStart, $timeEnd);
    }

    public function runTask()
    {
        $this->twitchStreamsAPI->getToken();
    }

    public function onlineCount()
    {
        return $this->cncOnlineCount->getTotal();
    }

    public function streamCount()
    {
        $data = $this->twitchStreamsAPI->getStreamByGames(Constants::getTwitchGames());
        $counts = $this->twitchStreamsAPI->getCounts($data);

        return response($counts)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function totalStreamCount()
    {
        $data = $this->twitchStreamsAPI->getStreamByGames(Constants::getTwitchGames());
        $count = $this->twitchStreamsAPI->getCounts($data);
        
        $total = 0;
        foreach($count as $k => $arr)
        {
            $total += count($arr);
        }

        return response($total)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function streamByGameId($gameId, $limit = 100)
    {
        $data = $this->twitchStreamsAPI->getStreamByGame($gameId, $limit);

        return response($data)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function videosByGameId($gameId)
    {
        $data = $this->twitchStreamsAPI->getVideosByGame($gameId);

        return response($data)
            ->withHeaders([
                "max-age" => Constants::getCacheSeconds()
            ]
        );
    }

    public function getPlayerRank($gameSlug, $playerId)
    {
        return MatchPlayer::profile($gameSlug, $playerId);
    }

    public function searchPlayers(Request $request, $gameSlug)
    {
        $searchRequest = filter_var($request->search, FILTER_SANITIZE_STRING);
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);

        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason($matchType);
        if ($leaderboardHistory == null)
        {
            abort(404);
        }
        
        $cacheKey = "APIController.searchPlayersByRequest".$matchType.$searchRequest;
        return Leaderboard::getPlayersFromSearchRequest(
            $cacheKey, 
            $leaderboardHistory->id, 
            $searchRequest, 
            $limit=10
        );
    }

    public function getPlayerRankWebView(Request $request, $gameSlug, $playerId)
    {
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason($matchType);
        if ($leaderboardHistory == null)
        {
            return view('api.error', ["message" => ""]);
        }   

        $profile = MatchPlayer::profile($gameSlug, $playerId);
        if ($profile == null)
        {
            return view('api.error', ["message" => ""]);
        }

        $gamesLast24Hours = $profile->player()->playerGames24Hours($matchType, $leaderboardHistory->id);
        $winstreak = $profile->player()->playerWinStreak($matchType, $leaderboardHistory->id);

        $badge = LeaderboardHelper::getBadgeByRank($profile->rank);

        $inputColor = APILeaderboardProfile::validateColorRequest($request);
        $inputSize = APILeaderboardProfile::validateSizeRequest($request);
        $inputLayout = APILeaderboardProfile::validateLayoutRequest($request);
        $inputBorder = APILeaderboardProfile::validateBorderRequest($request);
        $inputBranding = APILeaderboardProfile::validateBrandingRequest($request);
        $validatedProps = APILeaderboardProfile::buildProfile($request);

        return view('api.leaderboard.player.webview', 
            [
                "profile" => $profile,
                "badge" => $badge,
                "winstreakHighest" => $winstreak["highest"],
                "winstreakCurrent" => $winstreak["current"],
                "gamesLast24Hours" => $gamesLast24Hours,
                "properties" => $validatedProps,
                "inputColor" => $inputColor,
                "inputLayout" => $inputLayout,
                "inputSize" => $inputSize,
                "inputBorder" => $inputBorder,
                "inputBranding" => $inputBranding
            ]
        );
    }

    public function configRankWebView(Request $request, $gameSlug, $playerId)
    {
        $matchType = Match::getMatchTypeByGameSlug($gameSlug);
        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason($matchType);
        
        if ($leaderboardHistory == null)
        {
            return view('api.error', ["message" => ""]);
        }   

        $profile = MatchPlayer::profile($gameSlug, $playerId);
        if ($profile == null)
        {
            return view('api.error', ["message" => ""]);
        }

        $gamesLast24Hours = $profile->player()->playerGames24Hours($matchType, $leaderboardHistory->id);
        $winstreak = $profile->player()->playerWinStreak($matchType, $leaderboardHistory->id);

        $badge = LeaderboardHelper::getBadgeByRank($profile->rank);
        $inputColor = APILeaderboardProfile::validateColorRequest($request);
        $inputSize = APILeaderboardProfile::validateSizeRequest($request);
        $inputLayout = APILeaderboardProfile::validateLayoutRequest($request);
        $inputBorder = APILeaderboardProfile::validateBorderRequest($request);
        $inputBranding = APILeaderboardProfile::validateBrandingRequest($request);
        $validatedProps = APILeaderboardProfile::buildProfile($request);
        $generatedUrl = APILeaderboardProfile::buildProfileWebViewUrl($gameSlug, $playerId);

        return view('api.leaderboard.player.config', 
            [
                "profile" => $profile,
                "badge" => $badge,
                "gamesLast24Hours" => $gamesLast24Hours,
                "winstreakHighest" => $winstreak["highest"],
                "winstreakCurrent" => $winstreak["current"],
                "properties" => $validatedProps,
                "inputColor" => $inputColor,
                "inputLayout" => $inputLayout,
                "inputSize" => $inputSize,
                "inputBorder" => $inputBorder,
                "inputBranding" => $inputBranding,
                "generatedUrl" => $generatedUrl
            ]
        );
    }

    public function APIController()
    {
        return view('api.error');
    }
}