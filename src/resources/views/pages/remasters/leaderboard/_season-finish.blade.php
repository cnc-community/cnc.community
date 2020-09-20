@if($activeSeason == false)
<div class="leaderboard-listing-recent-games">
    <div class="main-content">
        <h2 class="section-title">Season {{ $season}} Complete</h2>
        <p class="section-description">
            Congratulations to everyone who achieved their goals. This season has since ended.<br/> <a href="?">View the active season?</a>
        </p>
    </div>
</div>
@endif