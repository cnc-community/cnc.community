<?php

namespace App\Http\CustomView\Components\Leaderboard;

use App\Http\CustomView\AbstractCustomView;

class LeaderboardMatchDetails extends AbstractCustomView
{
    private $mapName;
    private $mapPreview;
    private $matchDuration;
    private $startTime;

    public function __construct($mapName, $mapPreview, $matchDuration, $startTime)
    {
        $this->mapName = $mapName;
        $this->mapPreview = $mapPreview;
        $this->matchDuration = $matchDuration;
        $this->startTime = $startTime;

        $this->renderContents();
    }

    public function render()
    {
        ?>
        <div>
            <div class="match-details">
                <div>Map: <strong><?php echo $this->mapName; ?></strong></div>
                <div>Duration: <strong><?php echo $this->matchDuration; ?></strong></div>
                <div>Date: <strong><?php echo $this->startTime; ?></strong></div>
            </div>
            <div class="map-preview">
                <img src="<?php echo $this->mapPreview; ?>" alt="<?php echo $this->mapName; ?>" />
            </div>
        </div>
        <?php
    }
}