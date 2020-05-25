@extends('layouts.app')

@section('title', 'Remasters')
@section('page-class', 'remasters')

@section('hero')
<div class="video" style="background-image: url('/assets/images/posters/cnc-remastered.jpg')">
    <video autoplay="true" loop muted 
        poster="/assets/images/posters/cnc-remastered.jpg"
        src="//cdn.jsdelivr.net/gh/cnc-community/files/cnc-remastered.mp4">
    </video>
</div>
<div class="content center">
    <div class="title">
        <img src="assets/images/logos/cnc-remastered-logo.png" alt="C&C Remaster Logo" />
    </div>
    <h1 class="small-h1">
        Find the latest streams, mods and maps for the C&amp;C Remastered Collection.
    </h1>
    <div class="buttons">
        <a href="#streams" class="btn btn-primary" title="View Streams">Streams</a>
        <a href="#news" class="btn btn-primary" title="View News">News</a>
        <a href="#workshop-items" class="btn btn-primary" title="View Mods">Workshop Mods</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section news-listings">
    <div class="main-content center">
        <div class="feature-cta" style="background-image: url('/assets/images/command-and-conquer-remastered.jpg')">
            <div class="feature-text">
                <a class="btn btn-play" href="https://www.youtube.com/watch?v=9iMfypQj3k0&feature=emb_logo" target="_blank" rel="nofollow">
                    <i class="icon-play"></i>
                </a>
                <p>Establishing battlefield control on June 5, 2020.</p>
            </div>

            <div class="buttons">
                <a class="btn btn-primary btn-icon" title="Buy on EA Origin" rel="nofollow" href="https://www.origin.com/gbr/en-us/store/command-and-conquer/command-and-conquer-remastered">Buy on Origin <i class="icon-origin"></i></a>
                <a class="btn btn-primary btn-icon" title="Buy on Steam" rel="nofollow" href="https://store.steampowered.com/agecheck/app/1213210/">Buy on Steam <i class="icon-steam"></i></a>
            </div>
        </div>
    </div>
</section>

<section id="news" class="section news-listings">
    <div class="main-content">
        <h2 class="section-title">Official Intel</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($news); ?>
    </div>
</section>

<section id="workshop-items" class="news-listings">
    <div class="main-content">
        <h2 class="section-title">Latest C&amp;C Remasters Workshop Mods</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\WorkShopListing($workShopItems); ?>
    </div>
</section>

<section id="streams" class="section stream-listings">
    <div class="main-content">
        <?php if (count($streams) == 0): ?>
            <h2 class="section-title">Latest Remastered videos</h2>
            <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
        <?php else: ?>
            <h2 class="section-title">Latest Remastered streams</h2>
            <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
        <?php endif; ?>
    </div>
</section>
@endsection