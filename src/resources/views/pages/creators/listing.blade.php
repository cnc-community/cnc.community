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
        <a href="?game_id=1900" id="game-id-1900" class="twitch-game-link">Tiberian Sun <span class="count">0</span></a>
        <a href="?game_id=16580" id="game-id-16580" class="twitch-game-link">Red Alert 2 <span class="count">0</span></a>
        <a href="?game_id=5090" id="game-id-5090" class="twitch-game-link">Yuri's Revenge <span class="count">0</span></a>
        <a href="?game_id=3813" id="game-id-3813" class="twitch-game-link">Renegade <span class="count">0</span></a>
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

@endsection

@section("scripts")
<script src="/assets/js/TwitchStreamByGameId.js" defer></script>
<script src="/assets/js/TwitchCountNav.js" defer></script>
@endsection