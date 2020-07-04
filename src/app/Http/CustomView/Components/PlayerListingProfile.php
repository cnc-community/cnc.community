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
        $this->renderContents();
    }

    public function render()
    {
        ?>
             <a href="<?php echo $this->url; ?>" class="leaderboard-item <?php echo $this->rank == 1 ? "gold": ""; ?>" title="View <?php echo $this->name; ?> stats">

                <div class="col col-10">
                    <div class="player-badge">
                        <img src="<?php echo $this->badge["image"]; ?>" alt="<?php echo $this->badge["rank"];?>" />
                    </div>
                </div> 

                <div class="col col-10">
                    <div class="rank">
                        <?php echo $this->rank; ?>
                    </div>
                </div>

                <div class="col col-50">
                    <div class="player-name"><h3><?php echo $this->name; ?></h3></div>
                </div>
                
                <div class="col col-10 col-visible-lg">
                    <div class="wins"><?php echo $this->wins; ?></div>
                </div>
                
                <div class="col col-10 col-visible-lg">
                    <div class="losses"><?php echo $this->losses; ?></div>
                </div>       
                
                <div class="col col-10 col-visible-lg">
                    <div class="played"><?php echo $this->wins += $this->losses; ?></div>
                </div>
                
                <div class="col col-10 col-visible-lg">
                    <div class="points"><?php echo round($this->points); ?></div>
                </div>

                <div class="stats col-hidden-lg">
                    <div class="wins"><?php echo $this->wins; ?> wins</div>
                    <div class="losses"><?php echo $this->losses; ?> losses</div>
                    <div class="played"><?php echo $this->wins += $this->losses; ?> played</div>
                    <div class="points"><?php echo round($this->points); ?> points</div>
                </div>
            </a>
        <?php 
    }
}