<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class PlayerDetailProfileStats extends AbstractCustomView
{
    private $name;
    private $wins;
    private $losses;
    private $badge;
    private $points;
    private $rank;
    private $faction;
    private $wonGame;
    private $url;

    public function __construct(
        $name, 
        $wins, 
        $losses, 
        $badge, 
        $points, 
        $rank, 
        $faction, 
        $wonGame, 
        $url)
    {
        $this->name = $name;
        $this->wins = $wins;
        $this->losses = $losses;
        $this->badge = $badge;
        $this->points = $points;
        $this->rank = $rank;
        $this->faction = $faction;
        $this->wonGame = $wonGame;
        $this->url = $url;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <a class="player <?php echo $this->wonGame == true ? "won-game" : "lost-game" ?>" href="<?php echo $this->url; ?>" title="View <?php echo $this->name; ?> stats">
                <div class="player-detail-rank">
                    <div class="player-badge">
                        <img src="<?php echo $this->badge["image"]; ?>" alt="Rank" />
                        <small class="rank-title"><?php echo $this->badge["rank"];?></small>
                    </div>
                    <div class="rank">
                        #<?php echo $this->rank; ?> 
                    </div>
                    <div class="details">
                        <div class="player-name"><h3><?php echo $this->name; ?></h3></div>
                        <div class="player-stats">
                            <div>Wins <?php echo $this->wins; ?></div>
                            <div>Lost <?php echo $this->losses; ?></div>
                            <div>Points <?php echo round($this->points); ?></div>
                        </div>
                    </div>
                    <div class="faction">
                        <img src="/assets/images/leaderboard/<?php echo $this->faction; ?>.png" />
                    </div>
                    <div class="game-status <?php echo $this->wonGame == true ? "won-game": "lost-game"?>">
                        <h3>
                            <?php echo $this->wonGame ? "WON": "LOST"; ?>
                        </h3>
                    </div>
                </div>
            </a>
        <?php 
    }
}