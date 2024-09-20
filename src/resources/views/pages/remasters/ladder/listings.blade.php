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
    function getRankIcon($rank) {
        if ($rank <= 16) {
            return 'general.png';
        } elseif ($rank <= 200) {
            return 'major.png';
        } elseif ($rank <= 400) {
            return 'captain.png';
        } elseif ($rank <= 600) {
            return 'lieutenant.png';
        } else {
            return 'sergeant.png';
        }
    }
@endphp

@section('hero-video')
    <?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('page-class', "$slug $randomImage")

@section('hero')
    <div class="content center">
        <div class="leaderboard-logo" style="margin-bottom:1rem;">
            @if ($abbrev == 'red-alert')
                <img src="{{ Vite::asset('resources/assets/images/logos/red-alert-remastered.png') }}" alt="{{ $gameName }} logo" />
            @else
                <img src="{{ Vite::asset('resources/assets/images/logos/tiberian-dawn-remastered.png') }}" alt="{{ $gameName }} logo" />
            @endif
        </div>
        <div class="buttons">
            <a href="https://www.ea.com/games/command-and-conquer/command-and-conquer-remastered" class="btn btn-secondary btn-icon" target="_blank">
                Buy on Steam
                <i class="icon-steam"></i>
            </a>
        </div>
        {{-- <h1 class="text-uppercase">{{ $gameName }} Leaderboards</h1> --}}
    </div>
@endsection

@section('content')

    <div class="page-background">

        <div class="main-content">
            <div class="leaderboard-hero">
                <div class="leaderboard-description">
                    <h1 class="leaderboard-hero-title">{{ $gameName }}<br /> <span class="light">Leaderboard Rankings</span></h1>
                </div>
                <div class="leaderboard-logo">
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="season-selector" style="padding-left:40px">
                <span>Current Selected Season: <br /><strong>Season {{ $currentSelectedSeason }}</strong></span><br /><br />
                <label for="season">Previous Season Select</label><br/>
                <select id="season" name="season" onchange="fetchSeasonData()">
                    <option value="" disabled selected>-- Select Season --</option>
                    @for ($i = 1; $i <= $latestSeason; $i++)
                        <option value="{{ $i }}">Season {{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <script>
            function fetchSeasonData() {
                var season = document.getElementById('season').value;
                var currentUrl = window.location.href;
                var game = currentUrl.includes('tiberian-dawn') ? 'tiberian-dawn' : 'red-alert';
                window.location.href = `/command-and-conquer-remastered/leaderboard/${game}/season/` + season;
            }
        </script>

        <div class="main-content">
            <div class="leaderboard-player-listings">
                <div class="leaderboard-listings">
                    <div class="headers">
                        <div class="col col-10 rank">Rank</div>
                        <div class="col col-10 rank">Position</div>
                        <div class="col col-20">Name</div>
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
                                    <img style="max-height: 3.6rem" src="https://raw.githubusercontent.com/cnc-community/cnc.community/master/src/resources/assets/images/leaderboard/{{ getRankIcon($player->rank) }}" alt="Rank Icon" />
                                </div>
                            </div>
                            <div class="col col-10 visible-lg">
                                <div class="rank">
                                    <span style="font-size:1.4rem">#{{ $player->rank }} </span>
                                </div>
                            </div>

                            <div class="col col-20 visible-lg">
                                <div class="player-name">
                                    @foreach ($steamLookup as $steamProfile)
                                        @if ($player->steamids[0] == $steamProfile->steam_id)
                                            @php
                                                $avatarUrl = $steamProfile->avatarfull ?? 'https://avatars.akamai.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg';
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
                                                @if ($player->rank == 1)
                                                    🎖️
                                                @elseif ($player->rank == 2)
                                                    🥈
                                                @elseif ($player->rank == 3)
                                                    🥉
                                                @endif

                                                {{ \App\ViewHelper::renderSpecialOctal($steamProfile->personaname) }}

                                                @if ($player->rank == 1)
                                                    🎖️
                                                @elseif ($player->rank == 2)
                                                    🥈
                                                @elseif ($player->rank == 3)
                                                    🥉
                                                @endif
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
                                @php
                                    $totalGames = $player->wins + $player->loses;
                                    $winRate = $totalGames > 0 ? ($player->wins / $totalGames) * 100 : 0;
                                    $roundedWinRate = ceil($winRate);
                                @endphp
                                <div>
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
                                                    <a href="https://steamcommunity.com/profiles/{{ $player->steamids[0] }}" class="profile-avatar" rel="nofollow">
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
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em" fill="#01ad00">
                                                                    <path d="m280-400 200-200 200 200H280Z" />
                                                                </svg>
                                                                #{{ $rank }}
                                                            </span>
                                                        @else
                                                            <span class="rank-history rank-red" style="color: #ad0036;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 -960 960 960" width="1em" fill="#ad0036">
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
