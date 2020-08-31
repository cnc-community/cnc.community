@extends('layouts.app')

@section('title', 'Leaderboards - Command & Conquer Remastered')
@section('description', 'Quick Match Leaderboard player rankings for Command & Conquer Remastered Collection, Tiberian Dawn and Red Alert.')

@section('meta')
<meta property="og:image" content="https://cnc.community/assets/images/meta2.png?v=1.0">
@endsection

@section('page-class', 'leaderboard-listings')

@section('hero-video')
<?php 
    $videoSrc= $heroVideo["src"]; 
    $videoPoster = $heroVideo["poster"]; 
?>

<div class="video" style="background-image: url('{{ $videoPoster }}')">
    <video autoplay="true" loop muted preload="none"
        poster="{{ $videoPoster }}"
        src="{{ $videoSrc}} ">
    </video>
</div>
@endsection

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">C&amp;C Remastered Leaderboards</h1>
    <p class="lead">
        Search the top 1000 in our C&amp;C Remastered Leaderboards for Tiberian Dawn Remastered, and Red Alert Remastered.
    </p>
    <div class="buttons">
        <a class="btn btn-secondary" href="/command-and-conquer-remastered/leaderboard/tiberian-dawn" title="Tiberian Dawn Leaderboard">Tiberian Dawn Leaderboard</a>
        <a class="btn btn-secondary" href="/command-and-conquer-remastered/leaderboard/red-alert" title="Red Alert Remastered Leaderboard">Red Alert Leaderboard</a>
    </div>
</div>
@endsection

@section('content')
<section class="section section-dark-alt section-about">
    <div class="main-content center">
        <div class="center-box">
            <h1 class="section-title">C&amp;C Remastered <br/>Web Leaderboards <span class="light">have arrived</span></h1>
            <p class="section-description">
                We're currently in the early stages of building a web leaderboard for the C&amp;C Remastered Collection.
                You will be able to search the top 1000 player quick match rankings for Tiberian Dawn Remastered and Red Alert Remastered. 
            </p>
            <p>
                If you have suggestions or would like to keep up to date with our proposed updates, come join our website discord.
            </p>

            <div class="buttons">
                <a class="btn btn-secondary btn-icon" href="https://discord.gg/g8gaKkY" title="Chat on our discord" target="_blank">
                    Join our Website Discord 
                    <i class="icon-discord"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection