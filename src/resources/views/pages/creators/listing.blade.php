@extends('layouts.app')

@section('title', 'Creators')
@section('page-class', 'creators')

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        Creators
    </h1>
    <p class="lead">
        Find all the C&C Twitch Streamers playing Command &amp; Conquer 
    </p>
    
    <div class="twitch-games-navbar">
        <a href="?game_id=4012" id="game-id-4012" class="twitch-game-link">Tiberian Dawn <span class="count">0</span></a>
        <a href="?game_id=235" id="game-id-235" class="twitch-game-link">Red Alert <span class="count">0</span></a>
        <a href="?game_id=10393" id="game-id-10393" class="twitch-game-link">Red Alert - Counterstrike <span class="count">0</span></a>
        <a href="?game_id=14999" id="game-id-14999" class="twitch-game-link">Red Alert - The Aftermath <span class="count">0</span></a>
        <a href="?game_id=1900" id="game-id-1900" class="twitch-game-link">Tiberian Sun <span class="count">0</span></a>
        <a href="?game_id=20015" id="game-id-20015" class="twitch-game-link">Tiberian Sun Firestorm <span class="count">0</span></a>
        <a href="?game_id=16580" id="game-id-16580" class="twitch-game-link">Red Alert 2 <span class="count">0</span></a>
        <a href="?game_id=5090" id="game-id-5090" class="twitch-game-link">Yuri's Revenge <span class="count">0</span></a>
        <a href="?game_id=3813" id="game-id-3813" class="twitch-game-link">Renegade <span class="count">0</span></a>
        <a href="?game_id=18881" id="game-id-18881" class="twitch-game-link">Red Alert 3 <span class="count">0</span></a>
        <a href="?game_id=18733" id="game-id-18733" class="twitch-game-link">C&C 3: Kane's Wrath <span class="count">0</span></a>
        <a href="?game_id=16106" id="game-id-16106" class="twitch-game-link">C&C 3: Tiberium Wars <span class="count">0</span></a>
        <a href="?game_id=10070" id="game-id-10070" class="twitch-game-link">C&C: Generals <span class="count">0</span></a>
        <a href="?game_id=16487" id="game-id-16487" class="twitch-game-link">C&C: Zero hour <span class="count">0</span></a>
    </div>
</div>
@endsection

@section('content')
<section class="stream-listings">
    <div class="main-content">
        <h2 class="section-title">Command &amp; Conquer streamers</h2>

        <div id="streams" class="twitch-streams">
            <h3>No streams online for this game.</h3>
        </div>
    </div>
</section>

<section class="video-listings">
    <div class="main-content">
        <h2 class="section-title">Recent Command &amp; Conquer videos</h2>

        <div id="videos" class="twitch-streams">
            <h3>No videos found online for this game.</h3>
        </div>
    </div>
</section>

@endsection

@section("scripts")
<script src="/assets/js/TwitchStreamByGameId.js" defer></script>
<script src="/assets/js/TwitchVideoByGameId.js" defer></script>
<script src="/assets/js/TwitchCountNav.js" defer></script>
@endsection