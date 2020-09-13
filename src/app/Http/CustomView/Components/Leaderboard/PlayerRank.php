<?php

namespace App\Http\CustomView\Components\Leaderboard;

use App\Http\CustomView\AbstractCustomView;

class PlayerRank extends AbstractCustomView
{
    private $playerName;
    private $playerRank;
    private $playerBadge;
    private $playerBadgeTitle;

    public function __construct($playerName, $playerRank, $playerBadge, $playerBadgeTitle)
    {
        $this->playerName = $playerName;
        $this->playerRank = $playerRank;
        $this->playerBadge = $playerBadge;
        $this->playerBadgeTitle = $playerBadgeTitle;

        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="leaderboard-profile-rank">
                <div class="player-rank-name">
                    <div class="player-name">
                        <?php echo $this->playerName; ?>
                    </div>
                    <div class="rank">
                        <?php if($this->playerRank != -1): ?>
                            #<?php echo $this->playerRank; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="player-badge">
                    <img src="<?php echo $this->playerBadge; ?>" alt="<?php echo $this->playerBadgeTitle; ?>" />
                </div>
            </div>
        <?php
    }
}