<?php

namespace App\Http\CustomView\Components\Leaderboard;

use App\Http\CustomView\AbstractCustomView;
use App\Http\CustomView\Components\Avatar;

class LeaderboardMatchPlayer extends AbstractCustomView
{
    private $order;
    public function __construct($player, $order)
    {
        foreach($player as $k => $v)
        {
            $this->{$k} = $v;
        }
        $this->order = $order;
        $this->renderContents();
    }

    private function rank(): int { return $this->leaderboardProfile->rank(); }
    private function avatarImageUrl() { return $this->leaderboardProfile->avatarImageUrl(); }
    private function avatarUrl(): string { return $this->leaderboardProfile->avatarSteamUrl(); }
    private function playerName(): string { return $this->playerName; }
    private function playerBadge(): string { return $this->leaderboardProfile->badge()->badgeImage(); }
    private function playerRankTitle(): string { return $this->leaderboardProfile->badge()->badgeTitle(); }
    private function wins(): int { return $this->leaderboardProfile->wins(); }
    private function losses(): int { return $this->leaderboardProfile->losses(); }
    private function points(): int { return $this->leaderboardProfile->points(); }
    private function totalGames(): int { return $this->leaderboardProfile->totalGames(); }

    public function render()
    {
        ?>
        <div class="leaderboard-match-player leaderboard-match-player--order-<?php echo $this->order; ?>">
            <div class="leaderboard-match-profile">
                <?php 
                    new Avatar(
                        $this->playerName(), 
                        $this->avatarUrl(),
                        $this->avatarImageUrl()
                    ); 
                ?>
                
                <?php 
                    new PlayerRank(
                        $this->playerName(),  
                        $this->rank(),
                        $this->playerBadge(),
                        $this->playerRankTitle()
                    ); 
                ?>
            </div>
            <?php /*
            <div class="leaderboard-match-profile-stats">
                <div class="profile-stat overall">
                    <div>
                        <h3 class="profile-stat-title">Wins</h3>
                        <div class="quick-stats-value">
                            <strong><?php echo $this->wins(); ?></strong>
                        </div>
                    </div>
                    <div>
                        <h3 class="profile-stat-title">Losses</h3>
                        <div class="quick-stats-value">
                            <strong><?php echo $this->losses(); ?></strong>
                        </div>
                    </div>
                    <div>
                        <h3 class="profile-stat-title">Played</h3>
                        <div class="quick-stats-value">
                            <strong><?php echo $this->totalGames(); ?></strong>
                        </div>
                    </div>
                    <div>
                        <h3 class="profile-stat-title">Points</h3>
                        <div class="quick-stats-value">
                            <strong><?php echo $this->points(); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
        </div>
        <?php
    }
}