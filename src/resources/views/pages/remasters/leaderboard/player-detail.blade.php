@extends('layouts.app')
@section('title', ''.$gameName["long_name"].' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName["long_name"].' Leaderboard rankings, 1vs1')
@section('meta')
<meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection

@section('page-class', 'remasters page-leaderboard-profile '.  $gameSlug)

@section('content')

<div class="page-background">

    <div class="main-content">
        <div class="leaderboard-breadcrumb">
            <div>
                <a href="/command-and-conquer-remastered/leaderboard/{{$gameSlug}}?season={{$season}}" 
                    class="btn btn-transparent btn-back" 
                    title="back">
                    <
                </a>
            </div>
            <div class="leaderboard-breadcrumb-trail">
                <div>
                    <a href="/command-and-conquer-remastered/leaderboard/{{$gameSlug}}?season={{$season}}"
                        title="Back to all leaderboards">
                        Red Alert Remastered Leaderboard
                    </a>
                </div>
                <div class="spacer">/</div>
                <div>
                    <strong>{{ $player->playerName() }}</strong>
                </div>
            </div>
            <div class="leaderboard-breadcrumb-logo">
                <img src="{{ $gameLogo }}" alt="{{ $gameName["long_name"] }} logo" />
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="leaderboard-profile">

            <div class="leaderboard-profile-details">
                <div class="leaderboard-profile-avatar" style="background: url({{ $player->getSteamProfileAvatar() }})">
                </div>
                
                <div class="leaderboard-profile-rank">
                    <div class="player-name">
                        {{ $player->playerName() }}
                    </div>
                    <div class="rank">
                        #{{ $playerData->rank }}
                    </div>
                </div>

                <div class="leaderboard-profile-quick-stats">
                    <div class="profile-quick-stat games-played">
                        <h3 class="quick-stats-title">Games (Last 24 hours)</h3>
                        <div class="quick-stats-value">
                            <strong>{{ $playerStats["gamesLast24Hours"] }}</strong>
                        </div>
                    </div>

                    <div class="profile-quick-stat points">
                        <h3 class="quick-stats-title">Points</h3>
                        <div class="quick-stats-value">
                            <strong>{{ round($playerData->points) }}</strong>
                        </div>
                    </div>

                    <div class="profile-quick-stat overall">
                        <div>
                            <h3 class="quick-stats-title">Wins</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerData->wins }}</strong>
                            </div>
                        </div>
                        <div>
                            <h3 class="quick-stats-title">Losses</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerData->losses }}</strong>
                            </div>
                        </div>
                        <div>
                            <h3 class="quick-stats-title">Played</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerData->wins + $playerData->losses }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="leaderboard-profile-extra">
                <div class="leaderboard-profile-games">
                    <div>
                        Last 5 Games, High Winstreak etc
                    </div>
                </div>
                <div class="leaderboard-profile-factions">
                    <div>
                        Last 5 Games, High Winstreak etc
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="leaderboard-profile-recent-games">
    </div>
</div>
@endsection