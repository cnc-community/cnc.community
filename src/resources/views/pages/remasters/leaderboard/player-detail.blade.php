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
                    <i class="icon icon-left"></i>
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
                <?php 
                    $steamProfile = $player->getSteamProfile();

                    new App\Http\CustomView\Components\SteamAvatar(
                        $player->playerName(), 
                        $steamProfile["steamAvatarUrl"],
                        $steamProfile["steamProfileUrl"]
                    );
                ?>
                
                <?php 
                    new App\Http\CustomView\Components\Leaderboard\PlayerRank(
                        $player->playerName(), 
                        $playerLeaderboardProfile->rank(),
                        $playerLeaderboardProfile->badge()->badgeImage(),
                        $playerLeaderboardProfile->badge()->badgeTitle(),
                        $playerLeaderboardProfile->profileUrl()
                    ); 
                ?>

                <div class="leaderboard-profile-stats">
                    <div class="profile-stat games-played">
                        <h2 class="profile-stat-title">Games (Last 24 hours)</h2>
                        <div class="quick-stats-value">
                            <strong>{{ $playerLeaderboardProfileStats->gamesPlayedLast24Hours() }}</strong>
                        </div>
                    </div>

                    <div class="profile-stat points">
                        <h2 class="profile-stat-title">Points</h2>
                        <div class="quick-stats-value">
                            <strong>{{ $playerLeaderboardProfile->points() }}</strong>
                        </div>
                    </div>

                    <div class="profile-stat last-games-played">
                        <h2 class="profile-stat-title">Last 5 games</h2>

                        <div class="last-5-games">
                            @foreach($playerLeaderboardProfileStats->playerLast5GameStates() as $winState)
                            <div class="result {{ $winState == "W" ? "result--win": "result--loss"}}">{{ $winState }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="leaderboard-profile-extra">
                <div class="leaderboard-profile-games">
                   
                    <div class="profile-stat overall">
                        <div>
                            <h2 class="profile-stat-title">Wins</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->wins() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h2 class="profile-stat-title">Losses</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->losses() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h2 class="profile-stat-title">Played</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->totalGames() }}</strong>
                            </div>
                        </div>
                        <div>
                            <h2 class="profile-stat-title">Win Ratio</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfile->winRatio() }}%</strong>
                            </div>
                        </div>
                    </div>

                    <div class="profile-stat winstreaks">
                        <div>
                            <h2 class="profile-stat-title">Highest winstreak</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfileStats->winStreakHighest() }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="profile-stat winstreaks">
                        <div>
                            <h2 class="profile-stat-title">Current winstreak</h2>
                            <div class="quick-stats-value">
                                <strong>{{ $playerLeaderboardProfileStats->winStreakCurrent() }}</strong>
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
    </div>

    <div class="main-content">
        <div class="leaderboard-profile-recent-games leaderboard-games">

            <div class="leaderboard-search">
                <h3 class="text-uppercase">Recent Games</h3>
                <div class="leaderboard-bar">
                    <form>
                        <input type="hidden" name="season" value="{{ $season }}" />
                        <div class="form-group player-search">
                            <label class="label" for="search">Search for a player in these games</label>
                            <div class="search-box">
                                <div class="search-input">
                                    <input id="search" type="text" name="search" class="form-input" placeholder="Enter a player name.." value="{{ $search }}" />
                                    <?php if($search): ?>
                                    <a href="?search=&season={{ $season }}" title="Clear Search" class="btn-clear"><i class="icon-close-alt"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{ $playerLeaderboardProfileMatches->links() }}

            @foreach($playerLeaderboardProfileMatches as $leaderboardMatch)
                <?php new App\Http\CustomView\Components\Leaderboard\LeaderboardMatch(
                        $leaderboardMatch, 
                        $leaderboardHistory, 
                        $player,
                        $gameSlug
                    ); ?>
            @endforeach

            {{ $playerLeaderboardProfileMatches->links() }}
        </div>
    </div>
</div>
@endsection