<div class="other-rank-box">
    <div class="results">
        <div class="player-rank">
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