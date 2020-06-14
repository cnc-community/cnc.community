@extends('layouts.app')

@section('title', 'Command & Conquer Remastered Leaderboards')
@section('description', 'Find the latest leaderboard rankings for Command & Conquer Remastered Collection.')

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
        Find the elite in our new C&amp;C Remastered Leaderboards
    </p>
    <div class="buttons">
        <a class="btn btn-secondary" href="/command-and-conquer-remastered/leaderboard/tiberian-dawn" title="Tiberian Dawn Leaderboard">Tiberian Dawn Leaderboard</a>
        <a class="btn btn-secondary" href="/command-and-conquer-remastered/leaderboard/red-alert" title="Red Alert Remastered Leaderboard">Red Alert Leaderboard</a>
    </div>
</div>
@endsection

@section('content')
<section id="about" class="section section-dark-alt section-about">
    <div class="main-content center">
        <div class="center-box">
            <h1 class="section-title">Web Leaderboards <span class="light">have arrived</span></h1>
            <p class="section-description">
                We're currently in the early stages of building a web leaderboard for the C&amp;C Remastered Collection.
                If you have suggestions or would like to keep up to date with our proposed updates, come join our website discord.
            </p>

            <div class="buttons">
                <a class="btn btn-secondary btn-icon" href="/contact" title="Chat on our discord">
                    Join our Website Discord 
                    <i class="icon-discord"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection