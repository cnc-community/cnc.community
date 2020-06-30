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
                        #{{ $playerData->rank }} {{ $player->playerName() }}
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
            <div class="recent-games">
            <h3>Recent games</h3>
            {{ $matches->links() }}
            @foreach($matches as $match)
            <div class="recent-game">
                <div class="players">
                    <?php $player1 = $match->player1(); ?>
                    <?php $player1Stats = $match->player1()->leaderboardStats($leaderboardHistory); ?>

                    <?php if($player1Stats): ?>
                        <?php $player1Url = "/command-and-conquer-remastered/leaderboard/" . $gameSlug . "/player/" . $match->player1()->id; ?>
                        <?php new \App\Http\CustomView\Components\PlayerDetailProfileStats
                            (
                                $player1Stats->playerName(),
                                $player1Stats->wins,
                                $player1Stats->losses,
                                $player1Stats->playerBadge(),
                                $player1Stats->points,
                                $player1Stats->rank,
                                $match->player1Faction(),
                                $match->winningPlayer()->id == $player1->id,
                                $player1Url
                            ); 
                        ?>          
                    <?php else: ?>
                        Player {{ $match->player2()->player_name }} games data was not found
                    <?php endif; ?>

                    <?php $player2 = $match->player2(); ?>
                    <?php $player2Stats = $match->player2()->leaderboardStats($leaderboardHistory); ?>

                    <?php if($player2Stats): ?>
                        <?php $player2Url = "/command-and-conquer-remastered/leaderboard/" . $gameSlug . "/player/" . $match->player2()->id; ?>
                        <?php new \App\Http\CustomView\Components\PlayerDetailProfileStats
                            (
                                $player2Stats->playerName(),
                                $player2Stats->wins,
                                $player2Stats->losses,
                                $player2Stats->playerBadge(),
                                $player2Stats->points,
                                $player2Stats->rank,
                                $match->player2Faction(),
                                $match->winningPlayer()->id == $player2->id,
                                $player2Url
                            ); 
                        ?>
                    <?php else: ?>
                        Player {{ $match->player2()->player_name }} game data was not found
                    <?php endif; ?>
                </div>

                <div class="map-preview" style="background-image:url(/assets/images/leaderboard/maps/{{ $match->mapInternalName() }}.png)">
                    <div class="game-details">
                        <div><strong>Map:</strong> {{ $match->mapName() }}</div>
                        <div><strong>Duration:</strong> {{ $match->matchduration() }}</div>
                        <div class="date-played">{{ $match->startTime() }}</div>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $matches->links() }}
            </div>
        </div>
    </section>
</div>

@endsection