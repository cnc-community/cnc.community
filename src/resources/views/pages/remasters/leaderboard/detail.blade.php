@extends('layouts.app')

@section('title', ''.$gameName.' Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', ''.$gameName.' Leaderboard rankings, 1vs1')

@section('title', 'Command & Conquer Remastered Leaderboards')
@section('description', 'Find the latest leaderboard rankings for Command & Conquer Remastered Collection.')

@section('page-class', 'remasters leaderboard-detail '.  $gameSlug)

@section('content')
<div class="page-background">
    <section class="top-ranks">
        <div class="main-content">
            <div class="leaderboard-header">
                <div class="title">
                    <h1 class="section-title">{{ $gameName }}<br/> <span class="light">Leaderboard Rankings</span></h1>
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
                    <img src="{{ $gameLogo }}" alt="{{ $gameName }} logo" />
                </div>
            </div>
        </div>

        <?php if($pageNumber == 1 || $pageNumber == 0): ?>
        <div class="main-content">
            <p class="note"><small>Note: Ranks are synced every 30 minutes</small></p>
            <div class="ranks-top-15">
                <?php $i = 0; ?>
                <?php foreach($top15Data->chunk(5) as $chunk): ?>
                <?php $i++; ?>

                <div class="top-rank-box rank-type-{{ $i }}">
                    <div class="title">
                    <?php if($i == 1): ?>
                    <h3>{{ $gameName }}'s Elite </h3>
                    <?php elseif ($i == 2): ?>
                    <h3>{{ $gameName }}'s Pro</h3>
                    <?php else: ?>
                    <h3>{{ $gameName }}'s Upcoming</h3>
                    <?php endif; ?>
                    </div>
                    <div class="results">
                        @foreach($chunk as $result)
                        <a class="player-rank" href="{{ $gameSlug }}/player/{{ $result->player()->id}}">
                            <div class="details">
                                <div class="player-name"><h3>{{ $result->playerName() }}</h3></div>
                                <div class="player-stats">
                                    <div>Wins {{ $result->wins }}</div>
                                    <div>Lost {{ $result->losses }}</div>
                                    <div>Points {{ round($result->points) }}</div>
                                </div>
                            </div>
                            <div class="rank">
                                #{{ $result->rank }} 
                            </div>
                        </a>
                        @endforeach 
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="main-content">
            {{ $data->links() }}

            <div class="ranks-more">
                <?php foreach($data as $result): ?>
                <?php if($result->rank > 15): ?>
                <div class="other-rank-box">
                    <div class="results">
                        <div class="player-rank">
                            <div class="details">
                                <div class="player-name"><h3>{{ $result->player() }}</h3></div>
                                <div class="player-stats">
                                    <div>Wins {{ $result->wins }}</div>
                                    <div>Lost {{ $result->losses }}</div>
                                    <div>Points {{ round($result->points) }}</div>
                                </div>
                            </div>
                            <div class="rank">
                                #{{ $result->rank }} 
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            {{ $data->links() }}
        </div>
    </section>
</div>

@endsection