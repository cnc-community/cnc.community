@extends('layouts.app')

@section('title', ''.$gameName.' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName.' Leaderboard rankings, 1vs1')
@section('meta')
<meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection
@section('page-class', 'remasters leaderboard-detail leaderboard-profile-detail '.  $gameSlug)

@section('content')
<div class="page-background">
    <section class="top-ranks">
        <div class="main-content">
            <div class="leaderboard-header">
                <div class="title">
                    <h1 class="section-title">
                        {{ $player->playerName() }}
                    </h1>
                    <div class="player-stats">
                        <div>Wins {{ $playerData->wins }}</div>
                        <div>Lost {{ $playerData->losses }}</div>
                        <div>Points {{ round($playerData->points) }}</div>
                    </div>
                    <div class="buttons">
                        <a href="/command-and-conquer-remastered/leaderboard/{{$gameSlug}}" class="btn btn-outline" title="Back to all leaderboards">
                            Back to Leaderboard
                        </a>
                    </div>
                </div>
                <div class="logo">
                    <img src="{{ $gameLogo }}" alt="logo" />
                </div>
            </div>
        </div>
        <div class="main-content">
            <h3>Recent games</h3>
            <div>
                @foreach($matches as $match)
                <div class="player-versus" style="background:url(/assets/images/leaderboard/maps/{{ $match->mapInternalName() }}.png)">
                    <div class="player">
                        <div class="faction">
                            <img src="/assets/images/leaderboard/{{ $match->player1Faction()}}.png"/>
                        </div>

                        <div class="colour-box game-colour-{{ $match->player1Colour()}}">
                        </div>

                        <h3 class="player-name">
                            {{ $match->player1Name()}}
                        </h3>
                    </div>

                    <div class="versus">
                        <h4>Vs.</h4>
                    </div>

                    <div class="player">
                        <h3 class="player-name">
                            {{ $match->player2Name()}}
                        </h3>
                        <div class="colour-box game-colour-{{ $match->player2Colour()}}">
                        </div>
                        <div class="faction">
                            <img src="/assets/images/leaderboard/{{ $match->player2Faction()}}.png"/>
                        </div>
                    </div>
                </div>

                <div>
                    <strong>Map Name</strong>: {{ $match->mapName() }}
                    <strong>Match Duration</strong>: {{ $match->matchduration() }}
                    <strong>Winning Team Id</strong>: {{ $match->winningteamid }}
                </div>
                @endforeach

            </div>
        </div>
    </section>
</div>

@endsection