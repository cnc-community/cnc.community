@extends('layouts.app')
@section('title', "$gameName Leaderboard")
@section('description', "$gameName Leaderboard rankings, 1vs1")
@section('meta')
    <meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection

@php $slug = Str::slug($gameName) @endphp
@section('page-class', "$slug")

@section('hero')
    <div class="content center">
        <div class="leaderboard-logo">
            <img src="{{ Vite::asset('resources/assets/images/9bit/9bit-logo.png') }}" alt="{{ $gameName }} logo" />
        </div>
        <h1 class="text-uppercase">{{ $gameName }} Leaderboards</h1>
        <p class="lead">
            <a href="https://store.steampowered.com/app/1439750/9Bit_Armies_A_Bit_Too_Far/" class="btn btn-secondary btn-icon" target="_blank">Buy Game on steam
                <i class="icon-steam"></i>
            </a>
        </p>
    </div>
@endsection

@section('content')

    <div class="page-background">

        <div class="main-content">
            <div class="leaderboard-hero">
                <div class="leaderboard-description">
                    <h1 class="leaderboard-hero-title">{{ $gameName }}<br /> <span class="light">Leaderboard Rankings</span></h1>
                    <div class="button-group">
                        <a href="https://steamcommunity.com/linkfilter/?u=https%3A%2F%2Fdiscord.gg%2Fpetroglyph" class="btn btn-secondary btn-icon"
                            title="Join the 9Bit Discord" target="_blank">
                            Join the 9Bit Discord
                            <i class="icon-discord"></i>
                        </a>
                    </div>
                </div>
                <div class="leaderboard-logo">
                    <img src="{{ Vite::asset('resources/assets/images/9bit/9bit-factions.png') }}" alt="{{ $gameName }} factions" />
                </div>
            </div>
        </div>

        <div class="main-content">
            {{-- <div class="leaderboard-player-listings">
                {{ $ranks->links() }}
            </div> --}}

            <div class="leaderboard-player-listings">
                <div class="leaderboard-listings">
                    <div class="headers">
                        <div class="col col-10 rank">Rank</div>
                        <div class="col col-40">Name</div>
                        <div class="col col-10">Points</div>
                        <div class="col col-10">Wins</div>
                        <div class="col col-10">Losses</div>
                        <div class="col col-10">Played</div>
                        <div class="col col-10"></div>
                    </div>

                    @foreach ($data as $player)
                        <a href="" class="leaderboard-table-row @if ($player->rank == 1) gold @endif">
                            {{--                        
                            <div class="col col-10 hidden-lg">
                                <div class="player-badge">
                                    <img src="<?php echo $this->badge['image']; ?>" alt="<?php echo $this->badge['rank']; ?>" />
                                </div>
                            </div> --}}

                            <div class="col col-10 visible-lg">
                                <div class="rank">
                                    #{{ $player->rank }}
                                </div>
                            </div>

                            <div class="col col-40 visible-lg">
                                <div class="player-name">
                                    <h3>{{ $player->name ?? 'TBC' }}</h3>
                                </div>
                            </div>

                            <div class="col col-10 visible-lg">
                                <div class="points">{{ round($player->points) }}</div>
                            </div>

                            <div class="col col-10 visible-lg">
                                <div class="wins">{{ $player->wins }}</div>
                            </div>

                            <div class="col col-10 visible-lg">
                                <div class="losses">{{ $player->loses }}</div>
                            </div>

                            <div class="col col-10 visible-lg">
                                <div class="played">{{ $player->loses .= $player->wins }}</div>
                            </div>

                            <div class="col col-10 visible-lg">
                                {{-- <i class="icon icon-right"></i> --}}
                            </div>

                            <div class="stats hidden-lg">
                                <div class="player-name">
                                    <div class="player-rank-name">
                                        <h3>{{ $player->name ?? 'WIP' }}</h3>
                                    </div>
                                    <div class="other-stats">
                                        <div class="player-rank-stat">
                                            # {{ $player->rank }}
                                        </div>

                                        <div class="detailed-stats">
                                            <div class="wins"><strong>Wins:</strong>{{ $player->wins }}</div>
                                            <div class="losses"><strong>Losses:</strong> {{ $player->loses }}</div>
                                            <div class="played"><strong>Played:</strong> {{ $player->wins .= $player->loses }}</div>
                                            <div class="points"><strong>Points:</strong> {{ round($player->points) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
