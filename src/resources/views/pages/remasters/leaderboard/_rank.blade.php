<div class="leaderboard-badge">
    <div class="rank rank-type <?php echo strtolower($badge["rank"]); ?>">
        <div class="player-badge">
            <img src="<?php echo $badge["image"]; ?>" alt="Rank" />
            <small class="rank-title"><?php echo $badge["rank"];?></small>
            <div class="tier">Top <?php echo $tier ;?></div>
        </div>
    </div>
</div>