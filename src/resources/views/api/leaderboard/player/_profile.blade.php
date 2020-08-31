<div class="player-stats 
    player-stats--color-{{ $inputColor }} 
    player-stats--size-{{ $inputSize }} 
    player-stats--layout-{{ $inputLayout }}
    player-stats--border-{{ $inputBorder }}
    ">
    <?php $gamesPlayed = ($profile->wins + $profile->losses); ?>

    <?php if (in_array("badge", $properties)):?>
    <div class="player-badge">
        <img src="<?php echo $badge["image"]; ?>" alt="Rank" />
        <small class="rank-title"><?php echo $badge["rank"];?></small>
    </div>
    <?php endif; ?>

    <?php if (in_array("name", $properties)):?><div class="player-name">{{ $profile->name }}</div><?php endif; ?>
    <?php if (in_array("rank", $properties)):?><div>Rank: #<span>{{ $profile->rank }}</span></div><?php endif; ?>
    <?php if (in_array("wins", $properties)):?><div>Wins: <span>{{ $profile->wins }}</span></div><?php endif; ?>
    <?php if (in_array("lost", $properties)):?><div>Lost: <span>{{ $profile->losses }}</span></div><?php endif; ?>
    <?php if (in_array("points", $properties)):?><div>Points: <span>{{ round($profile->points) }}</span></div><?php endif; ?>
    <?php if (in_array("played", $properties)):?><div>Played: <span>{{ $gamesPlayed }}</span></div><?php endif; ?>
    <?php if (in_array("playedLast24Hours", $properties)):?><div>Played (Last 24 hrs): <span>{{ $gamesLast24Hours }}</span></div><?php endif; ?>

    <?php if ($inputBranding == "show-branding"): ?>
    <div class="branding">
        <div class="logo">
            <a href="/" title="C&C Community">
                <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>