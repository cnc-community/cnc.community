@extends('layouts.app')

@section('title', ''.$gameName.' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName.' Leaderboard rankings, 1vs1')

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
                <strong>Map Name</strong>: {{ $match->mapName() }}
                <br>
                <strong>Colours</strong>: {{ var_dump($match->colors) }}
                <br>
                <strong>Factions</strong>: {{ var_dump($match->factions) }}
                <br>
                <strong>Teams</strong>: {{ var_dump($match->teams) }}
                <br>
                <strong>Locations</strong>: {{ var_dump($match->locations) }}
                <br>              
                <strong>Match Duration</strong>: {{ $match->matchduration() }}
                <br>                
                <strong>Winning Team Id</strong>: {{ $match->winningteamid }}
                <br>               
                <strong>Player Ids</strong>: {{ var_dump($match->players) }}
                <br>
                <hr>
                @endforeach

            </div>
        </div>
    </section>
</div>

@endsection