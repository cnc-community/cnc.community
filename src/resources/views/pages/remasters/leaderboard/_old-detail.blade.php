@extends('layouts.app')

@section('title', ''.$gameName["long_name"].' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName["long_name"].' Leaderboard Player Rankings, 1vs1')

@section('meta')
<meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection

@section('page-class', 'remasters leaderboard-detail '.  $gameSlug)

@section('content')
<div class="page-background">
    <section class="top-ranks">
        <div class="main-content">
            <div class="leaderboard-header">
                <div class="title">
                    <h1 class="section-title">{{ $gameName["long_name"] }}<br/> <span class="light">Leaderboard Rankings</span></h1>
                    <p class="section-description">
                        Our leaderboards are still under development, join our discord to leave suggestions and feedback. 
                    </p>
                    <div class="buttons">
                        <a href="/command-and-conquer-remastered/leaderboard/" class="btn btn-theme" title="Back to all leaderboards">
                            All Leaderboards
                        </a>

                        <a href="https://discord.gg/g8gaKkY" class="btn btn-secondary btn-icon" title="Join our discord" target="_blank">
                            Join our Discord 
                            <i class="icon-discord"></i>
                        </a>
                    </div>
                </div>
                <div class="logo">
                    <img src="{{ $gameLogo }}" alt="{{ $gameName["long_name"] }} logo" />
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="leaderboard-bar">
                <form>
                    <div class="form-group player-search">
                        <label class="label" for="search">Search by player name</label>
                        <div class="search-box">
                            <div class="search-input">
                                <input id="search" type="text" name="search" class="form-input" placeholder="Enter a player name.." value="{{ $searchRequest }}" />
                                <?php if($searchRequest): ?>
                                <a href="?search=" title="Clear Search" class="btn-clear"><i class="icon-close-alt"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group season-select">
                        <select name="season" onchange="this.form.submit()">
                            <option value="">-Select a past season-</option>
                            <option value="1" <?php if($season == 1): ?>selected<?php endif; ?>>Season 1</option>
                        </select>
                    </div>
                </form>
                <div class="statistics">
                    <div class="statistics-list">
                        <div class="statistic-detail">
                            <div class="value text-uppercase">
                                <strong>{{ $stats["steamInGameCount"]}}</strong>
                            </div>              
                            <div class="title text-uppercase">
                                Players In-Game <br/><span>(Steam only TD + RA)</span>
                            </div>      
                        </div>
                        <div class="statistic-detail">
                            <div class="value text-uppercase">
                                <strong>{{ $stats["matchesPlayedLast24hours"]}}</strong>
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
            <?php if(count($data) > 0): ?>
            {{ $data->links() }}
            <?php endif; ?>

            <p class="note">Hint: Click into a profile below to view further stats!</p>
                <?php if($searchRequest): ?>
                <div class="search-results">
                    <p>
                        {{ count($data) }} results for "<strong>{{ $searchRequest }}</strong>". <br/>
                    </p>
                </div>
                <?php endif; ?>
                <div class="listings<?php if($searchRequest): ?> is-searching<?php endif; ?>">
                    <?php if(!$searchRequest): ?>
                    <div class="ranks">
                        <div class="top-16">
                            @foreach($pageRanks as $rank)
                                <?php $badge = \App\LeaderboardHelper::getBadgeByRank($rank); ?>
                                @include("pages.remasters.leaderboard._rank", ["badge" => $badge, "tier" => $rank])
                            @endforeach
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="leaderboard-listings">
                        <div class="headers">
                            <div class="col col-10 rank">Rank</div>
                            <div class="col col-50">Name</div>
                            <div class="col col-10">Points</div>
                            <div class="col col-10">Wins</div>
                            <div class="col col-10">Losses</div>
                            <div class="col col-10">Played</div>
                            <div class="col col-10">Win Rate</div>
                        </div>
                        <?php foreach($data as $result): ?>
                            <?php 
                                $url = $gameSlug ."/player/".$result->player()->id . "?season=".$season;
                                new \App\Http\CustomView\Components\PlayerListingProfile
                                (
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

            <?php if(count($data) > 0): ?>
            {{ $data->links() }}
            <?php endif; ?>
        </div>
    </section>
</div>
@endsection