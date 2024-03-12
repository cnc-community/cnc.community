<a href="{{ $url }}" @if ($externalLink) target="_blank" rel="nofollow noreferrer" @endif title="{{ $title }}"
    class="stat-game-box stat-game--image-{{ $gameAbrev }}">

    <div class="stat-game-box-logo">
        <img src="{{ $logo }}" alt="Game Logo" />
    </div>
    <div class="stat-game-online-count">
        {{ $title }}
        <div style="padding: 0.5rem;">
            @if ($onlineCount > 0)
                <strong>{{ $onlineCount }} online {{ $onlineService ?? '' }}</strong>
            @else
                <strong>{{ $onlineCount }} online {{ $onlineService ?? '' }}</strong>
            @endif
        </div>
        <div style="color:#e5e5e5">
            @if (isset($steamInGameCount) && $steamInGameCount > 0)
                <strong style="font-size:0.9rem;color:#a3a3a3;">{{ $steamInGameCount }} Players On Steam</strong>
            @endif
        </div>
    </div>
</a>
