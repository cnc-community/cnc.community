<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;
use App\ViewHelper;

class PlayerListingProfile extends AbstractCustomView
{
    private $name;
    private $wins;
    private $losses;
    private $badge;
    private $points;
    private $rank;
    private $url;

    private $totalGames;
    private $winRate;

    public function __construct(
        $name, 
        $wins, 
        $losses, 
        $badge, 
        $points, 
        $rank, 
        $url
    )
    {
        $this->name = ViewHelper::renderSpecialOctal($name);
        $this->wins = $wins;
        $this->losses = $losses;
        $this->badge = $badge;
        $this->points = $points;
        $this->rank = $rank;
        $this->url = $url;
        $this->totalGames = $wins + $losses;
        $this->winRate = round(($wins/$this->totalGames * 100));
        $this->renderContents();
    }

    public function render()
    {
        ?>
             <a href="<?php echo $this->url; ?>" class="leaderboard-table-row <?php echo $this->rank == 1 ? "gold": ""; ?>" title="View <?php echo $this->name; ?> stats">
         
                <div class="col col-10 hidden-lg">
                    <div class="player-badge">
                        <img src="<?php echo $this->badge["image"]; ?>" alt="<?php echo $this->badge["rank"];?>" />
                    </div>
                </div> 

                <div class="col col-10 visible-lg">
                    <div class="rank">
                        <?php echo $this->rank; ?>
                    </div>
                </div>

                <div class="col col-40 visible-lg">
                    <div class="player-name">
                        <h3><?php echo $this->name; ?></h3>
                    </div>
                </div>
                
                <div class="col col-10 visible-lg">
                    <div class="points"><?php echo round($this->points); ?></div>
                </div>

                <div class="col col-10 visible-lg">
                    <div class="wins"><?php echo $this->wins; ?></div>
                </div>

                <div class="col col-10 visible-lg">
                    <div class="losses"><?php echo $this->losses; ?></div>
                </div>       
                
                <div class="col col-10 visible-lg">
                    <div class="played"><?php echo $this->totalGames; ?></div>
                </div>

                <div class="col col-10 visible-lg">
                    <div class="wins"><?php echo $this->winRate; ?>%</div>
                </div>

                <div class="col col-10 visible-lg">
                    <i class="icon icon-right"></i>
                </div>

                <div class="stats hidden-lg">
                    <div class="player-name">
                        <div class="player-rank-name">
                            <div class="rank">
                                <?php echo $this->rank; ?>
                            </div>
                            <h3><?php echo $this->name; ?></h3>
                        </div>

                        <div class="detailed-stats">
                            <div class="wins"><strong>Wins:</strong> <?php echo $this->wins; ?></div>
                            <div class="losses"><strong>Losses:</strong> <?php echo $this->losses; ?></div>
                            <div class="played"><strong>Played:</strong> <?php echo $this->totalGames; ?></div>
                            <div class="points"><strong>Points:</strong> <?php echo round($this->points); ?></div>
                            <div class="points"><strong>Win Rate:</strong> <?php echo $this->winRate; ?>%</div>
                        </div>
                    </div>
                </div>
            </a>
        <?php 
    }
}