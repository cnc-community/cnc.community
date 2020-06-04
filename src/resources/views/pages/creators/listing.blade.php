@extends('layouts.app')

@section('title', 'Creators')
@section('page-class', 'creators')

@section('hero-video')
<div class="video" style="background-image: url('/assets/images/creators.jpg')">
</div>
@endsection

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        Creators
    </h1>
    <p class="lead">
        Discover Twitch Streamers who play Command &amp; Conquer
    </p>
</div>
@endsection

@section('content')
<section class="stream-listings">
    <div class="main-content">
        <div class="twitch-games-navbar">
            <a href="?gameName=tiberian-dawn" id="game-id-4012" class="twitch-game-link {{ $gameName == "tiberian-dawn" ? " active": ""}}">Tiberian Dawn <span class="count">0</span></a>
            <a href="?gameName=red-alert" id="game-id-235" class="twitch-game-link {{ $gameName == "red-alert" ? " active": ""}}">Red Alert <span class="count">0</span></a>
            <a href="?gameName=tiberian-sun" id="game-id-1900" class="twitch-game-link  {{ $gameName == "tiberian-sun" ? " active": ""}}">Tiberian Sun <span class="count">0</span></a>
            <a href="?gameName=red-alert-2" id="game-id-16580" class="twitch-game-link {{ $gameName == "red-alert-2" ? " active": ""}}">Red Alert 2 <span class="count">0</span></a>
            <a href="?gameName=red-alert-2-yuris-revenge" id="game-id-5090" class="twitch-game-link {{ $gameName == "red-alert-2-yuris-revenge" ? " active": ""}}">Yuri's Revenge <span class="count">0</span></a>
            <a href="?gameName=renegade" id="game-id-3813" class="twitch-game-link {{ $gameName == "renegade" ? " active": ""}}">Renegade <span class="count">0</span></a>
            <a href="?gameName=generals" id="game-id-10070" class="twitch-game-link {{ $gameName == "generals" ? " active": ""}}">C&C: Generals <span class="count">0</span></a>
            <a href="?gameName=zero-hour" id="game-id-16487" class="twitch-game-link {{ $gameName == "zero-hour" ? " active": ""}}">Zero hour <span class="count">0</span></a>
            <a href="?gameName=tiberium-wars" id="game-id-16106" class="twitch-game-link {{ $gameName == "tiberium-wars" ? " active": ""}}">C&C 3: Tiberium Wars <span class="count">0</span></a>
            <a href="?gameName=red-alert-3" id="game-id-18881" class="twitch-game-link {{ $gameName == "red-alert-3" ? " active": ""}}">Red Alert 3 <span class="count">0</span></a>
            <a href="?gameName=command-and-conquer-3-kanes-wrath" id="game-id-18733 {{ $gameName == "command-and-conquer-3-kanes-wrath" ? " active": ""}}" class="twitch-game-link">C&amp;C 3: Kane's Wrath <span class="count">0</span></a>
            <a href="?gameName=remasters" id="game-id-517837" class="twitch-game-link {{ $gameName == "remasters" ? " active": ""}}">C&C: Remastered Collection <span class="count">0</span></a>
        </div>

        <h2 class="section-title">
        <?php if($gameFullName): ?>
        <?php echo $gameFullName; ?> streams
        <?php else: ?>
        All streams
        <?php endif; ?>
        </h2>

        <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
    </div>
</section>

<section class="video-listings">
    <div class="main-content">
        <h2 class="section-title">
        <?php if($gameFullName): ?>
        Recent <?php echo $gameFullName; ?> videos
        <?php else: ?>
        Recent videos
        <?php endif; ?>
        </h2>

        <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
    </div>
</section>

@endsection

@section("scripts")
<script src="/assets/js/TwitchCountNav.js" defer></script>
@endsection