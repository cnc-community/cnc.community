@extends('layouts.app')
@section('title', $gameName["long_name"].' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', $gameName["long_name"].' Leaderboard rankings, 1vs1')
@section('meta')
<meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection

@section('page-class', 'remasters page-leaderboard-listing '. $gameSlug)

@section('content')

<div class="page-background">

    <div class="main-content">
        <div class="leaderboard-hero">
            <div class="leaderboard-description">
                <h1 class="leaderboard-hero-title">{{ $gameName["long_name"] }}<br /> <span class="light">Leaderboard Rankings</span></h1>
                <p class="leaderboard-hero-description">
                    Our leaderboards have received an update. Join our website discord to leave your suggestions and feedback.
                </p>
                <div class="button-group">
                    <a href="/command-and-conquer-remastered/leaderboard/" class="btn btn-primary" title="Back to all leaderboards">
                        All Leaderboards
                    </a>

                    <a href="https://discord.gg/g8gaKkY" class="btn btn-secondary btn-icon" title="Join our discord" target="_blank">
                        Join our Discord
                        <i class="icon-discord"></i>
                    </a>
                </div>
            </div>
            <div class="leaderboard-logo">
                <img src="{{ $gameLogo }}" alt="{{ $gameName["long_name"] }} logo" />
            </div>
        </div>
    </div>

    <div class="main-content">
        @include("pages.remasters.leaderboard._season-finish")

        <div class="leaderboard-listing-recent-games">
            <div class="leaderboard-search-and-stats">
                <div class="leaderboard-search">
                    <div class="leaderboard-bar">
                        <form>
                            <div class="form-group player-search">
                                <label class="label" for="search">Search for a player</label>
                                <div class="search-box">
                                    <div class="search-input">
                                        <input id="search" type="text" name="search" class="form-input" placeholder="Enter a player name.." value="{{ $search }}" />
                                        <?php if ($search) : ?>
                                            <a href="?search=&season={{ $season }}" title="Clear Search" class="btn-clear"><i class="icon-close-alt"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group season-select">
                                <select name="season" onchange="this.form.submit()">
                                    <option value="">-Select a past season-</option>
                                    <option value="1" <?php if ($season == 1) : ?>selected<?php endif; ?>>Season 1</option>
                                    <option value="2" <?php if ($season == 2) : ?>selected<?php endif; ?>>Season 2</option>
                                    <option value="3" <?php if ($season == 3) : ?>selected<?php endif; ?>>Season 3</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="leaderboard-stats">
                    <div class="profile-stat games-played">
                        <h2 class="profile-stat-title">Games (Last 24 hours)</h2>
                        <div class="quick-stats-value">
                            <strong>{{ $stats["matchesPlayedLast24hours"]}}</strong>
                        </div>
                    </div>
                    {{--
                    <div class="profile-stat points">
                        <h2 class="profile-stat-title">Active Players (Last 24 hours)</h2>
                        <div class="quick-stats-value">
                            <strong>346</strong>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>


        <div class="leaderboard-player-listings">
            {{ $data->links() }}
        </div>

        <div class="leaderboard-player-listings">
            <div class="ranks">
                <div class="top-16">
                    @foreach($pageRanks as $rank)
                    <?php $badge = \App\LeaderboardHelper::getBadgeByRank($rank); ?>
                    @include("pages.remasters.leaderboard._rank", ["badge" => $badge, "tier" => $rank])
                    @endforeach
                </div>
            </div>
            <div class="leaderboard-listings">
                <div class="headers">
                    <div class="col col-10 rank">Rank</div>
                    <div class="col col-40">Name</div>
                    <div class="col col-10">Points</div>
                    <div class="col col-10">Wins</div>
                    <div class="col col-10">Losses</div>
                    <div class="col col-10">Played</div>
                    <div class="col col-10">Win Rate</div>
                    <div class="col col-10"></div>
                </div>
                <?php foreach ($data as $result) : ?>
                    <?php
                    $url = $gameSlug . "/player/" . $result->player()->id . "?season=" . $season;
                    new \App\Http\CustomView\Components\PlayerListingProfile(
                        $result->player_name,
                        $result->wins,
                        $result->losses,
                        $result->player()->playerBadge($result->rank),
                        $result->points,
                        $result->rank,
                        $url
                    );
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
@endsection