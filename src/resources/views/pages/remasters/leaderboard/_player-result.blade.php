<div class="other-rank-box">
    <div class="results">
        <div class="player-rank">
            <?php $badge = $result->playerBadge(); ?>
            <?php if($badge != null): ?>
            <div class="player-badge">
                <img src="{{ $badge["image"] }}" alt="Rank" />
                <small class="rank-title">{{ $badge["rank"] }}</small>
            </div>
            <?php endif; ?>
            <div class="details">
                <div class="player-name"><h3>{{ $result->playerName() }}</h3></div>
                <div class="player-stats">
                    <div>Wins {{ $result->wins }}</div>
                    <div>Lost {{ $result->losses }}</div>
                    <div>Points {{ round($result->points) }}</div>
                </div>
            </div>
            <div class="rank">
                #{{ $result->rank }}
            </div>
        </div>
    </div>
</div>