@extends('layouts.app')
@section('title', "$gameName Leaderboard")
@section('description', "$gameName Leaderboard rankings, 1vs1")
@section('meta')
    <meta property="og:image" content="{{ Vite::asset('resources/assets/images/meta3.png') }}">
@endsection

@php
    $slug = Str::slug($gameName);
    $imageClasses = ['hero-bg', 'hero-bg-1', 'hero-bg-2', 'hero-bg-3', 'hero-bg-4'];
    $randomImage = $imageClasses[array_rand($imageClasses)];
@endphp

@section('page-class', "$slug $randomImage")

@section('hero')
    <div class="content center">
        <div class="leaderboard-logo" style="margin-bottom:1rem;">
            <img src="{{ Vite::asset('resources/assets/images/9bit/9bit-logo.png') }}" alt="{{ $gameName }} logo" />
        </div>
        <div class="buttons">
            <a href="https://store.steampowered.com/app/1439750/9Bit_Armies_A_Bit_Too_Far/" class="btn btn-secondary btn-icon" target="_blank">
                Buy on Steam
                <i class="icon-steam"></i>
            </a>

            <a class="btn btn-secondary btn-icon" target="_blank" title="Visit Petroglpyh Website" rel="nofollow" href="https://petroglyphgames.com/">
                Petroglyph Homepage
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
            <div class="season-select" style="padding-left:40px; background: #001127e3; padding-bottom: 1em;">
                <span>Current Selected Season <br /><strong>Season {{ $currentSelectedSeason }}</strong></span><br /><br />
                <label for="season">Previous Season Select</label><br />
                <select id="season" name="season" onchange="fetchSeasonNineBitData()" style="border: 1px solid #173081">
                    <option value="" disabled selected>-- Select Season --</option>
                    @for ($i = 1; $i <= $latestSeason; $i++)
                        <option value="{{ $i }}" @if ($i == $currentSelectedSeason) selected @endif>Season {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <script>
            function fetchSeasonNineBitData() {
                var season = document.getElementById('season').value;
                var currentUrl = window.location.href;
                window.location.href = `/9bitarmies/leaderboard/season/` + season;
            }
        </script>

        <div class="main-content">
            <div class="leaderboard-player-listings">
                <div class="leaderboard-listings">
                    <div class="headers">
                        <div class="col col-10 rank">Rank</div>
                        <div class="col col-30">Name</div>
                        <div class="col col-10">Points</div>
                        <div class="col col-10">Wins</div>
                        <div class="col col-10">Losses</div>
                        <div class="col col-10">Played</div>
                        <div class="col col-10">Win Rate</div>
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

                            <div class="col col-30 visible-lg">
                                <div class="player-name">
                                    @foreach ($steamLookup as $steamProfile)
                                        @if ($player->steamids[0] == $steamProfile->steam_id)
                                            @php
                                                $avatarUrl =
                                                    $steamProfile->avatarfull ??
                                                    'https://avatars.akamai.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg';
                                            @endphp
                                            @if ($steamProfile->avatarfull)
                                                <a href="https://steamcommunity.com/profiles/{{ $player->steamids[0] }}" class="profile-avatar" rel="nofollow">
                                                    <div class="profile-avatar-fx"></div>
                                                    <div class="profile-avatar-image" style="background-image: url('{{ $avatarUrl }}')"></div>
                                                </a>
                                            @else
                                                <div class="profile-avatar">
                                                    <div class="profile-avatar-fx"></div>
                                                    <div class="profile-avatar-image" style="background-image: url('{{ $avatarUrl }}')"></div>
                                                </div>
                                            @endif
                                            <h3>
                                                {{ \App\ViewHelper::renderSpecialOctal($steamProfile->personaname) }}
                                            </h3>
                                        @endif
                                    @endforeach
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

                            <div class="col col-10 visible-lg">
                                <div class="win-rate">
                                    @php
                                        $totalGames = $player->wins + $player->loses;
                                        $winRate = $totalGames > 0 ? ($player->wins / $totalGames) * 100 : 0;
                                        $roundedWinRate = ceil($winRate);
                                    @endphp
                                    {{ $roundedWinRate }}%
                                </div>
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
                                        @foreach ($steamLookup as $steamProfile)
                                            @if ($player->steamids[0] == $steamProfile->steam_id)
                                                @if ($steamProfile->avatarfull)
                                                    <a href="https://steamcommunity.com/profiles/{{ $player->steamids[0] }}" class="profile-avatar"
                                                        rel="nofollow">
                                                        <div class="profile-avatar-fx"></div>
                                                        <div class="profile-avatar-image" style="background-image: url('{{ $steamProfile->avatarfull }}')">
                                                        </div>
                                                    </a>
                                                @endif
                                                <h3>
                                                    {{ \App\ViewHelper::renderSpecialOctal($steamProfile->personaname) }}
                                                </h3>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="other-stats">
                                        <div class="player-rank-stat">
                                            # {{ $player->rank }}
                                        </div>

                                        <div class="detailed-stats">
                                            <div class="wins"><strong>Wins:</strong> {{ $player->wins }}</div>
                                            <div class="losses"><strong>Losses:</strong> {{ $player->loses }}</div>
                                            <div class="played"><strong>Played:</strong> {{ $player->wins += $player->loses }}</div>
                                            <div class="points"><strong>Points:</strong> {{ round($player->points) }}</div>
                                            <div class="win-rate"><strong>Win Rate:</strong>
                                                @php
                                                    $totalGames = $player->wins + $player->loses;
                                                    $winRate = $totalGames > 0 ? ($player->wins / $totalGames) * 100 : 0;
                                                    $roundedWinRate = ceil($winRate);
                                                @endphp
                                                {{ $roundedWinRate }}%
                                            </div>
                                            <div class="history"><strong>History:</strong>
                                                @php
                                                    $rankHistory = array_splice($player->rankhistory, -1);
                                                @endphp
                                                @foreach ($rankHistory as $rank)
                                                    @if ($rank !== $player->rank)
                                                        @if ($rank > $player->rank)
                                                            <span class="rank-history rank-green" style="color: #01ad00;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em"
                                                                    fill="#01ad00">
                                                                    <path d="m280-400 200-200 200 200H280Z" />
                                                                </svg>
                                                                #{{ $rank }}
                                                            </span>
                                                        @else
                                                            <span class="rank-history rank-red" style="color: #ad0036;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em"
                                                                    fill="#ad0036">
                                                                    <path d="M480-360 280-560h400L480-360Z" />
                                                                </svg>
                                                                #{{ $rank }}
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
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
