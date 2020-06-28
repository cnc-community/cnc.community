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
            <div class="recent-games">
            @foreach($matches as $match)
                <div class="recent-game">

                <div class="players">
                    {{-- <strong>Winning Team Id</strong>: {{ $match->winningteamid }} --}}

                    <?php $player1 = $match->player1(); ?>
                    <?php $player1Stats = $match->player1()->leaderboardStats($leaderboardHistory); ?>

                    <?php new \App\Http\CustomView\Components\PlayerDetailProfileStats
                        (
                            $player1Stats->playerName(),
                            $player1Stats->wins,
                            $player1Stats->losses,
                            $player1Stats->playerBadge(),
                            $player1Stats->points,
                            $player1Stats->rank,
                            $match->player1Faction(),
                            $wonGame = ($match->winningTeamId() == 0)
                        ); 
                    ?>                    

                    <?php $player2 = $match->player2(); ?>
                    <?php $player2Stats = $match->player2()->leaderboardStats($leaderboardHistory); ?>

                    <?php new \App\Http\CustomView\Components\PlayerDetailProfileStats
                        (
                            $player2Stats->playerName(),
                            $player2Stats->wins,
                            $player2Stats->losses,
                            $player2Stats->playerBadge(),
                            $player2Stats->points,
                            $player2Stats->rank,
                            $match->player2Faction(),
                            $wonGame = ($match->winningTeamId() == 1)
                        ); 
                    ?>                    
                </div>

                <div class="map-preview" style="background-image:url(/assets/images/leaderboard/maps/{{ $match->mapInternalName() }}.png)">
                    <div class="game-details">
                        <div>{{ $match->mapName() }}</div>
                        <div>{{ $match->matchduration() }}</div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </section>
</div>

@endsection