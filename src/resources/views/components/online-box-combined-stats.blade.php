<div class="stat-game-box stat-game--image-{{ $gameAbrev }}">

    <div class="stat-game-box-logo">
        <img src="{{ $logo }}" alt="Game Logo" />
    </div>
    <div class="stat-game-online-count">
        <strong>
            {{ $title }}
        </strong>

        <div style="color:#e5e5e5">
            @if (isset($steamInGameCount) && $steamInGameCount > 0)
                <strong style="font-size:0.9rem;color:#a3a3a3;">{{ $steamInGameCount }} Players On Steam</strong>
            @endif
        </div>

        <div class="stats-container">
            @foreach ($stats as $stat)
                <div>
                    @if ($stat['serviceUrl'])
                        <a href="{{ $stat['serviceUrl'] }}" rel="nofollow noreferrer" target="_blank" class="service-link" title="{{ $stat['service'] }}">
                            {{ $stat['count'] }} online {{ $stat['service'] }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="how-to-play">
        <a href="{{ $url }}" @if ($externalLink) target="_blank" rel="nofollow noreferrer" @endif class="btn btn-primary btn-sm btn-icon"
            title="{{ $title }}">
            How to play
        </a>
    </div>
</div>
