@extends('layouts.app')

@section('title', 'Remasters')
@section('page-class', 'remasters')

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
    <div class="title">
        <img src="/assets/images/logos/cnc-remastered-logo.png" alt="C&C Remaster Logo" />
    </div>
    <h1 class="small-h1">
        Find the latest streams, mods and maps for the C&amp;C Remastered Collection.
    </h1>
    <div class="buttons">
        <a href="/command-and-conquer-remastered/workshop-mods" class="btn btn-primary" title="View Mods">Mods &amp; Maps</a>
        <a href="#streams" class="btn btn-primary" title="View Streams">Streams</a>
        <a href="#news" class="btn btn-primary" title="View News">News</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section section-buy">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">

                <h1 class="section-title"><span class="light">Play now!</span> <br /> C&amp;C Remastered Collection</h1>
                <p>
                    The Command &amp; Conquer Remastered Collection Delivers 4K Graphics, 
                    Rebuilt Multiplayer, Enhanced UI, the Completely Remastered Legendary Soundtrack by Frank Klepacki and more.
                </p>
                <div class="buttons">
                    <a class="btn btn-secondary btn-icon" title="Buy on EA Origin" rel="nofollow" href="https://www.origin.com/gbr/en-us/store/command-and-conquer/command-and-conquer-remastered">Buy on Origin <i class="icon-origin"></i></a>
                    <a class="btn btn-secondary btn-icon" title="Buy on Steam" rel="nofollow" href="https://store.steampowered.com/agecheck/app/1213210/">Buy on Steam <i class="icon-steam"></i></a>
                </div>
            </div>
            <div class="col-50 feature-text">
                <div class="feature-video">
                    <div class="embed-iframe">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/9iMfypQj3k0" 
                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                <div class="featured-logos">
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
        </div>
    </div>
</section>


<section id="tiberiandawn" class="section section-grey workshop-introduction">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">Tiberian Dawn Remastered</span> <br /> Maps &amp; Mods</h1>
                <p>
                    Find a map or mod you like below. <br class="hidden-xs" />
                    Open the link and click the Subscribe button 
                    for it to appear in game.
                </p>
            </div>
            <div class="col-50 feature-logo">
                <img src="/assets/images/logos/tiberian-dawn-remastered.png" alt="Tiberian Dawn Remastered" />
                <div class="buttons">
                    <a href="/command-and-conquer-remastered/workshop-mods#tdmods" class="btn btn-primary" title="Maps">View Top Mods</a>
                    <a href="/command-and-conquer-remastered/workshop-mods#tdmaps" class="btn btn-primary" title="Mods">View Top Maps</a>
                </div>
            </div>
        </div>
    </div>

    <div id="tdtop" class="main-content center workshop-listings">
        <h2 class="section-title"><span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($workShopItems); ?>
        </div>
    </div>
</section>

<section id="redalert" class="section section-grey workshop-introduction">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">Red Alert Remastered</span> <br /> Maps &amp; Mods</h1>
                <p>
                    Find a map or mod you like below. <br class="hidden-xs" />
                    Open the link to Steam and click the Subscribe button 
                    for it to appear in game.
                </p>
            </div>
            <div class="col-50 feature-logo">
                <img src="/assets/images/logos/red-alert-remastered.png" alt="Red Alert Remastered" />
                <div class="buttons">
                    <a href="/command-and-conquer-remastered/workshop-mods#ramods" class="btn btn-primary btn-theme-red" title="Maps">View Top Mods</a>
                    <a href="/command-and-conquer-remastered/workshop-mods#ramaps" class="btn btn-primary btn-theme-red" title="Mods">View Top Maps</a>
                </div>
            </div>
        </div>
    </div>

    <div id="tdtop" class="main-content center workshop-listings">
        <h2 class="section-title"><span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($workShopItems); ?>
        </div>
    </div>
</section>

<section id="streams" class="section stream-listings">
    <div class="main-content">
        <h2 class="section-title">C&amp;C Remastered Live Streams</h2>
        <?php if($streams == null): ?>
            <p>Nobody is streaming right now, check out the previous streams below.</p>
        <?php else: ?>
            <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
        <?php endif; ?>

        <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
    </div>
</section>

<section id="news" class="section news-listings">
    <div class="main-content">
        <h2 class="section-title">C&amp;C Remastered News</h2>
        <p class="section-description">
            News surrounding the Command &amp; Conquer Remastered Collection
        </p>

        <div class="items-wrap">
            <?php new App\Http\CustomView\Components\NewsListing($news); ?>
        </div>
    </div>
</section>
@endsection