@extends('layouts.app')

@section('title', 'Remasters')
@section('page-class', 'remasters')

@section('hero-video')
<?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
<div class="content center">
    <div class="title">
        <img src="assets/images/logos/cnc-remastered-logo.png" alt="C&C Remaster Logo" />
    </div>
    <h1 class="small-h1">
        Find the latest streams, mods and maps for the C&amp;C Remastered Collection.
    </h1>
    <div class="buttons">
        <a href="#workshop-items" class="btn btn-primary" title="View Mods">Mods &amp; Maps</a>
        <a href="#streams" class="btn btn-primary" title="View Streams">Streams</a>
        <a href="#news" class="btn btn-primary" title="View News">News</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section news-listings">
    <div class="main-content center">
        <div class="feature-cta" style="background-image: url('/assets/images/command-and-conquer-remastered.jpg')">
            <div class="feature-text">
                <h2>
                    Command &amp; Conquer Remastered Collection <br/> Official Reveal Trailer
                </h2>
                <a class="btn btn-primary" href="https://www.youtube.com/watch?v=9iMfypQj3k0&feature=emb_logo" target="_blank" rel="nofollow">
                    <i class="icon-play"></i>
                </a>
                <p>Establishing battlefield control on June 5, 2020.</p>
            </div>

            <div class="buttons">
                <a class="btn btn-secondary btn-icon" title="Buy on EA Origin" rel="nofollow" href="https://www.origin.com/gbr/en-us/store/command-and-conquer/command-and-conquer-remastered">Buy on Origin <i class="icon-origin"></i></a>
                <a class="btn btn-secondary btn-icon" title="Buy on Steam" rel="nofollow" href="https://store.steampowered.com/agecheck/app/1213210/">Buy on Steam <i class="icon-steam"></i></a>
            </div>
        </div>
        
        <div class="featured-logos">
            <div>
                <p class="produced-by text-center">
                   C&amp;C Remastered Collection Produced by <br/> <a href="https://petroglyphgames.com/">Petroglyph Games</a> &amp; <a href="https://commandandconquer.com" title="EA - Command & Conquer" rel="nofollow">Electronic Arts</a>
                </p>
            </div>
            <div class="logos">
                <a href="https://petroglyphgames.com/" title="Petroglyph Games" rel="nofollow">
                    <img src="/assets/images/logos/petroglyph-games.png" alt="Petroglyph Games" />
                </a>
                <a href="https://commandandconquer.com" title="EA - Command & Conquer" rel="nofollow">
                    <img src="/assets/images/logos/ea.png" alt="" />
                </a>
            </div>
        </div>
    </div>
</section>

<section id="workshop-items" class="section section-green workshop-listings">
    <div class="main-content">
        <h2 class="section-title">Top C&amp;C Remastered Mods &amp; Maps </h2>

        <p class="section-description">
            Explore the latest from the Steam Workshop, showing the most popular Tiberian Dawn and Red Alert Mods, aswell as the latest Maps.
        </p>

        <div class="workshop-items">
            <?php new App\Http\CustomView\Components\WorkShopListingSlider($__env, $workShopItems); ?>
        </div>
        
        <div class="view-all">
            <a href="command-and-conquer-remastered/mods-maps" title="Mods & Maps" class="btn btn-primary">View all Mods &amp; Maps</a>
        </div>
    </div>
</section>

<section id="streams" class="section stream-listings">
    <div class="main-content">
        <h2 class="section-title">Latest Remastered streams</h2>
        <?php if($streams == null): ?>
            <p>There's no-one currently streaming the C&amp;C Remastered Collection, but check out the previous streams below.</p>
        <?php else: ?>
            <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
        <?php endif; ?>

        <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
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
@endsection