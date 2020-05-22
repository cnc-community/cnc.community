@extends('layouts.app')

@section('title', 'Remasters')
@section('page-class', 'Remasters')

@section('hero')
<div class="video">
    <video autoplay="true" loop muted src="https://media.contentapi.ea.com/content/dam/ea/command-conquer/remastered/videos/2020/03/ccrem-section-bg-video-deep-dive-trailer-darkened.mp4
    ">
    </video>
</div>
<div class="content center">
    <h1 class="text-uppercase">
        Command &amp; Conquer - Remastered
    </h1>
    <p class="lead">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
    </p>
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
        <h2 class="section-title">Video + Buy links</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($news); ?>
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
        <h2 class="section-title">Workshop Items</h2>
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
