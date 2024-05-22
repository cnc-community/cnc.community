@extends('layouts.app')
@section('title', "$gameName Leaderboard")
@section('description', "$gameName Leaderboard rankings, 1vs1")
@section('meta')
    <meta property="og:image" content="https://cnc.community/assets/images/meta3.png?v=1.0">
@endsection

@php $slug = Str::slug($gameName) @endphp
@section('page-class', "$slug")

@section('hero')
    <div class="content center">
        <div class="leaderboard-logo" style="margin-bottom:1rem;">
            <img src="{{ Vite::asset('resources/assets/images/9bit/9bit-logo.png') }}" alt="{{ $gameName }} logo" />
        </div>
        {{-- <h1 class="text-uppercase">{{ $gameName }} Leaderboards</h1> --}}
        <div class="buttons">
            <a href="https://store.steampowered.com/app/1439750/9Bit_Armies_A_Bit_Too_Far/" class="btn btn-secondary btn-icon" target="_blank">Buy Game on Steam
                <i class="icon-steam"></i>
            </a>

            <a class="btn btn-secondary btn-icon" target="_blank" title="Visit Petroglpyh Website" rel="nofollow" href="https://petroglyphgames.com/">Petroglyph
                Homepage
                <i class="icon-petroglyph"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')

    <div class="page-background">

        <div class="main-content">
            <div class="leaderboard-hero">
                <div class="leaderboard-description">
                    <h1 class="leaderboard-hero-title">{{ $gameName }}<br /> <span class="light">Leaderboard Rankings</span></h1>
                    <div class="button-group">
                        <a href="https://discord.gg/ygGFZxz" class="btn btn-secondary btn-icon" title="Join the official Petroglyph Discord" target="_blank">
                            Join the official Petroglyph Discord
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
            <div class="leaderboard-player-listings">
                <div class="leaderboard-listings">
                    <div class="headers">
                        <div class="col col-10 rank">Rank</div>
                        <div class="col col-40">Name</div>
                        <div class="col col-10">Points</div>
                        <div class="col col-10">Wins</div>
                        <div class="col col-10">Losses</div>
                        <div class="col col-10">Played</div>
                        <div class="col col-10">History</div>
                        {{-- <div class="col col-10"></div> --}}
                    </div>

                    @foreach ($data as $player)
                        <div class="leaderboard-table-row @if ($player->rank == 1) gold @endif">

                            <div class="col col-10 visible-lg">
                                <div class="rank">
                                    <span style="font-size:1.4rem">#{{ $player->rank }}</span>
                                </div>
                            </div>

                            <div class="col col-40 visible-lg">
                                <div class="player-name">
                                    <h3>
                                        {{ $player->name ?? 'TBC' }}
                                        <span>
                                            <a href="https://steamcommunity.com/profiles/{{ $player->steamids[0] }}">
                                                <i class="icon icon-steam" style="font-size:1.3rem; margin-left:1rem;"></i>
                                            </a>
                                        </span>
                                    </h3>
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
                                <div class="played">{{ $player->wins += $player->loses }}</div>
                            </div>
                            {{--
                            <div class="col col-10 visible-lg">
                                 <i class="icon icon-right"></i>
                            </div>
                            --}}
                            <div class="col col-10 visible-lg">
                                @php
                                    $rankHistory = array_splice($player->rankhistory, -1);
                                @endphp
                                @foreach ($rankHistory as $rank)
                                    @if ($rank !== $player->rank)
                                        @if ($rank > $player->rank)
                                            <div class="rank-history rank-green" style="color: #01ad00;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#01ad00">
                                                    <path d="m280-400 200-200 200 200H280Z" />
                                                </svg>
                                                #{{ $rank }}
                                            </div>
                                        @else
                                            <div class="rank-history rank-red" style="color: #ad0036;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ad0036">
                                                    <path d="M480-360 280-560h400L480-360Z" />
                                                </svg>
                                                #{{ $rank }}
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
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
                                            <div class="played"><strong>Played:</strong> {{ $player->wins += $player->loses }}</div>
                                            <div class="points"><strong>Points:</strong> {{ round($player->points) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
