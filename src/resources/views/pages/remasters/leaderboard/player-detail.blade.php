@extends('layouts.app')
@section('title', $player->playerName() .' - '.$gameName["long_name"].' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', $player->playerName() .' - '.$gameName["long_name"].' Leaderboard rankings, 1vs1')
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
                        {{ $gameName["long_name"] }} Leaderboard
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
                <?php new App\Http\CustomView\Components\Avatar($player->playerName(), $player->getSteamProfileAvatar() );?>
                
                <div class="leaderboard-profile-rank">
                    <div class="player-name">
                        {{ $player->playerName() }}
                    </div>
                    <div class="rank">
                        #{{ $playerLeaderboardProfile->rank() }}
                    </div>
                </div>

                <div class="leaderboard-profile-stats">

                    <div class="profile-stat overall">
                        <div>
                            <h3 class="profile-stat-title">Wins</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->wins() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h3 class="profile-stat-title">Losses</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->losses() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h3 class="profile-stat-title">Played</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->totalGames() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h3 class="profile-stat-title">Win Ratio</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->winRatio() }}%</strong>
                            </div>
                        </div>
                    </div>

                    <div class="profile-stat games-played">
                        <h3 class="profile-stat-title">Games (Last 24 hours)</h3>
                        <div class="quick-stats-value">
                            <strong>{{ $playerLeaderboardProfileStats->gamesPlayedLast24Hours() }}</strong>
                        </div>
                    </div>

                    <div class="profile-stat points">
                        <h3 class="profile-stat-title">Points</h3>
                        <div class="quick-stats-value">
                            <strong>{{ $playerLeaderboardProfile->points() }}</strong>
                        </div>
                    </div>

                </div>
            </div>

            <div class="leaderboard-profile-extra">
                <div class="leaderboard-profile-games">
                   
                    <div class="profile-stat last-games-played">
                        <h2 class="profile-stat-title">Last 5 games</h2>

                        <div class="last-5-games">
                            @foreach($playerLeaderboardProfileStats->playerLast5GameStates() as $winState)
                            <div class="result {{ $winState == "W" ? "result--win": "result--loss"}}">{{ $winState }}</div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="profile-stat winstreaks">
                        <div>
                            <h2 class="profile-stat-title">Highest winstreak</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfileStats->winStreakHighest() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h2 class="profile-stat-title">Current winstreak</h3>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfileStats->winStreakCurrent() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="leaderboard-profile-factions">
                <div class="profile-stat">
                    <h2 class="profile-stat-title">Faction stats</h2>

                    <div class="faction-stats-list">
                        @foreach($playerLeaderboardProfileStats->playerFactionStats() as $faction => $stats)
                        <div class="faction">
                            <div class="faction-image">
                                <img src="/assets/images/leaderboard/{{ $faction }}.png" />
                            </div>
                            <div class="faction-stats">
                                <div>
                                    Win Ratio
                                    <strong>{{ $stats->winRatio() }}%</strong>
                                </div>
                                <div>
                                    Wins
                                    <strong>{{ $stats->wins() }}</strong>
                                </div>
                                <div>
                                    Losses
                                    <strong>{{ $stats->losses() }}</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach 
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="leaderboard-profile-recent-games">
    </div>
</div>
@endsection