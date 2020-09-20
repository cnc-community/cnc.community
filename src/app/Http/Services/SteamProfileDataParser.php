<?php

namespace App\Http\Services;

use App\Constants;
use App\Leaderboard;
use App\LeaderboardData;
use App\LeaderboardHistory;
use App\Match;
use App\MatchPlayerSteamProfile;
use App\NewsFeedQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class SteamProfileDataParser
{
    private $steamHelper;
    public function __construct()
    {
        $this->steamHelper = new SteamHelper();
    }

    public function run()
    {
        // RA steam sync
        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason(Match::RA_1vs1);
        $this->syncProfileData($leaderboardHistory->id, 200, 0);
        $this->syncProfileData($leaderboardHistory->id, 200, 200);
        $this->syncProfileData($leaderboardHistory->id, 200, 400);
        $this->syncProfileData($leaderboardHistory->id, 200, 800);

        // TD steam sync
        $leaderboardHistory = Leaderboard::getActiveLeaderboardSeason(Match::TD_1vs1);
        $this->syncProfileData($leaderboardHistory->id, 200, 0);
        $this->syncProfileData($leaderboardHistory->id, 200, 200);
        $this->syncProfileData($leaderboardHistory->id, 200, 400);
        $this->syncProfileData($leaderboardHistory->id, 200, 800);
    }

    private function syncProfileData($leaderboardHistoryId, $limit, $offset)
    {
        $players = LeaderboardData::getLeaderboardPlayers($leaderboardHistoryId, $limit, $offset);
        $steamIds = Arr::pluck($players, "player_id");
        $steamList = implode(', ', $steamIds); 
        $players = $this->steamHelper->getSteamProfiles(Constants::remastersAppId(), $steamList);
        
        foreach($players as $player)
        {
            MatchPlayerSteamProfile::saveProfile(
                $player["steamid"], 
                $player["personaname"], 
                $player["avatar"],
                $player["avatarmedium"],
                $player["avatarfull"],
                $player["avatarhash"]
            );
        }
        sleep(3);
    }
}
