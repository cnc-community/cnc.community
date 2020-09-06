@extends('layouts.app')
@section('title', ''.$gameName["long_name"].' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName["long_name"].' Leaderboard rankings, 1vs1')
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
                    @if ($playerData == null )
                    <h1 class="section-title">
                        #Unranked {{ $player->playerName() }}
                    </h1>
                    @else
                    <h1 class="section-title">
                        #{{ $playerData->rank }} {{ $player->playerName() }}
                    </h1>
                    <div class="player-stats">
                        <?php $gamesPlayed = ($playerData->wins + $playerData->losses); ?>
                        <div>Wins: <span>{{ $playerData->wins }}</span></div>
                        <div>Lost: {{ $playerData->losses }}</div>
                        <div>Points: {{ round($playerData->points) }}</div>
                        <div>Played: {{ $gamesPlayed }}</div>
                    </div>
                     @endif
                    <div class="buttons">
                        <?php if($showWebView): ?>
                        <a href="{{ $webViewUrl}}" class="btn btn-outline">Go to your WebView Configuration</a>
                        <?php endif; ?>

                        <a href="/command-and-conquer-remastered/leaderboard/{{$gameSlug}}?season={{$season}}" class="btn btn-outline" title="Back to all leaderboards">
                            Back to Leaderboard
                        </a>
                    </div>
                </div>
                <div class="statistics">
                    <div class="statistics-list">

                        <div class="statistic-detail">
                            <div class="value text-uppercase">
                                <strong>{{ $playerStats["winstreak"]["current"] }}</strong>
                            </div>              
                            <div class="title text-uppercase">
                                Current Win Streak <br/><span>(this season)</span>
                            </div>      
                        </div>

                        <div class="statistic-detail">
                            <div class="value text-uppercase">
                                <strong>{{ $playerStats["winstreak"]["highest"] }}</strong>
                            </div>              
                            <div class="title text-uppercase">
                                Highest Win Streak <br/><span>(this season)</span>
                            </div>      
                        </div>

                        <div class="statistic-detail">
                            <div class="value text-uppercase">
                                <strong>{{ $playerStats["gamesLast24Hours"] }}</strong>
                            </div>              
                            <div class="title text-uppercase">
                                Games Played <br/><span>(last 24 hours)</span>
                            </div>      
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include("pages.remasters.leaderboard._season-finish")

        <div class="main-content">
            <div class="recent-games">

            <div class="leaderboard-bar">
                <form>
                    <input type="hidden" name="season" value="{{ $season }}" />
                    <div class="form-group player-search">
                        <label class="label" for="search">Search for a player in these games</label>
                        <div class="search-box">
                            <div class="search-input">
                                <input id="search" type="text" name="search" class="form-input" placeholder="Enter a player name.." value="{{ $searchRequest }}" />
                                <?php if($searchRequest): ?>
                                <a href="?search=" title="Clear Search" class="btn-clear"><i class="icon-close-alt"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{ $matches->links() }}
            <h3 class="text-uppercase">{{ $player->playerName()}}'s games </h3>
            @foreach($matches as $match)


            <div class="recent-game">
                <div class="players">

                    @foreach($match->teams() as $teamId => $teamArr)
                        @foreach($teamArr as $teamPlayer)
                        <?php 
                            $rank = $teamPlayer->playerRank($leaderboardHistory);
                            new \App\Http\CustomView\Components\PlayerDetailProfileStats
                            (
                                $teamPlayer->playerName(),
                                $teamPlayer->playerBadge($rank),
                                $rank,
                                $teamPlayer->playerFactionByMatchId($match->matchid),
                                $teamId == $match->winningTeamId(),
                                $teamPlayer->playerUrlByGameSlug($gameSlug)
                            ); 
                        ?>     
                        @endforeach
                    @endforeach
                </div>

                <div class="map-preview" style="background-image:url({{ \App\LeaderboardHelper::mapPreviewByInternalName($match->mapInternalName()) }}">
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