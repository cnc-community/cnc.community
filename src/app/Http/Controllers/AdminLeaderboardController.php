<?php

namespace App\Http\Controllers;

use App\Leaderboard;
use App\LeaderboardHistory;
use App\NewsFeedQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminLeaderboardController extends Controller
{
    private array $raSeasons = [
        "R1V1_BOARD_S_05" => 5,
        "R1V1_BOARD_S_06" => 6,
        "R1V1_BOARD_S_07" => 7,
        "R1V1_BOARD_S_08" => 8,
        "R1V1_BOARD_S_09" => 9,
        "R1V1_BOARD_S_10" => 10,
        "R1V1_BOARD_S_11" => 11,
        "R1V1_BOARD_S_12" => 12,
        "R1V1_BOARD_S_13" => 13,
        "R1V1_BOARD_S_14" => 14,
        "R1V1_BOARD_S_15" => 15,
        "R1V1_BOARD_S_16" => 16,
        "R1V1_BOARD_S_17" => 17,
        "R1V1_BOARD_S_18" => 18,
        "R1V1_BOARD_S_19" => 19,
        "R1V1_BOARD_S_20" => 20,
    ];

    private $tdSeasons = [
        "1V1_BOARD_S_05" => 5,
        "1V1_BOARD_S_06" => 6,
        "1V1_BOARD_S_07" => 7,
        "1V1_BOARD_S_08" => 8,
        "1V1_BOARD_S_09" => 9,
        "1V1_BOARD_S_10" => 10,
        "1V1_BOARD_S_11" => 11,
        "1V1_BOARD_S_12" => 12,
        "1V1_BOARD_S_13" => 13,
        "1V1_BOARD_S_14" => 14,
        "1V1_BOARD_S_15" => 15,
        "1V1_BOARD_S_16" => 16,
        "1V1_BOARD_S_17" => 17,
        "1V1_BOARD_S_18" => 18,
        "1V1_BOARD_S_19" => 19,
        "1V1_BOARD_S_20" => 20,
    ];

    public function __construct()
    {
        $this->middleware('auth');
        View::share('queue_count', NewsFeedQueue::count());
    }

    public function getLeaderboardManager()
    {
        $raLeaderboard = Leaderboard::where("type", "ra_1vs1")->first();
        $tdLeaderboard = Leaderboard::where("type", "td_1vs1")->first();

        $raLeaderboardHistory = LeaderboardHistory::getActiveSeasonByLeaderboard($raLeaderboard);
        $tdLeaderboardHistory = LeaderboardHistory::getActiveSeasonByLeaderboard($tdLeaderboard);

        return view(
            'admin.leaderboard.index',
            [
                "RAActiveSeasonId" => $raLeaderboardHistory ? $raLeaderboardHistory->getSeasonId() : "",
                "TDActiveSeasonId" => $tdLeaderboardHistory ? $tdLeaderboardHistory->getSeasonId() : "",
                "TDSeasonsRemaining" => $this->tdSeasons,
                "RASeasonsRemaining" => $this->raSeasons
            ]
        );
    }


    public function updateLeaderboard(Request $request)
    {
        $ra = Leaderboard::where("type", "ra_1vs1")->first();
        $td = Leaderboard::where("type", "td_1vs1")->first();

        // Update RA
        $raSeasonNumber = $this->raSeasons[$request->ra_active_season];
        $raActiveSeason = $request->ra_active_season;
        $raLeaderboardHistory = $this->setActiveLeaderboardSeason(
            $ra->id,
            $raSeasonNumber,
            $raActiveSeason
        );

        // Update TD
        $tdSeasonNumber = $this->tdSeasons[$request->td_active_season];
        $tdActiveSeason = $request->td_active_season;
        $tdLeaderboardHistory = $this->setActiveLeaderboardSeason(
            $td->id,
            $tdSeasonNumber,
            $tdActiveSeason
        );

        // Update other leaderboard histories to be inactive
        LeaderboardHistory::where("id", "!=", $raLeaderboardHistory->id)
            ->where("id", "!=", $tdLeaderboardHistory->id)
            ->update(["active" => 0]);

        return redirect()->back();
    }


    /**
     * Mark active leaderboard to sync with
     * 
     * @param int $leaderboardId 
     * @param int $seasonNumber 
     * @param string $seasonId 
     * @return LeaderboardHistory 
     */
    private function setActiveLeaderboardSeason(int $leaderboardId, int $seasonNumber, string $seasonId): LeaderboardHistory
    {
        $leaderboardHistory = LeaderboardHistory::where("season_id", $seasonId)
            ->where("leaderboard_id", $leaderboardId)
            ->first();

        if ($leaderboardHistory == null)
        {
            $leaderboardHistory = new LeaderboardHistory();
        }

        $leaderboardHistory->leaderboard_id = $leaderboardId;
        $leaderboardHistory->season_id = $seasonId;
        $leaderboardHistory->season = $seasonNumber;
        $leaderboardHistory->active = 1;
        $leaderboardHistory->save();

        return $leaderboardHistory;
    }
}
