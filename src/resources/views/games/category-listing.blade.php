<?php $howToPlaySteps = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category theme-'.$category->slug)
@section('hero-class', 'hero-'. $category->slug)

@section('hero')
<div class="video" style="background-image: url('/assets/images/posters/cnc-remastered.jpg')">
    <video autoplay="true" loop muted 
        poster="/assets/images/posters/cnc-remastered.jpg"
        src="//cdn.jsdelivr.net/gh/cnc-community/files@1.0/cnc-remastered.mp4">
    </video>
</div>

<div class="content center">
    <div class="title">
        <img src="{{ \App\ViewHelper::getGameLogoPathByName($category->slug) }}" alt="Game logo" />
    </div>
    <h1 class="small-h1">
        Experience and play {{ $category->title }} again. <br class="visible-md" />
        Discover {{ $category->title }} livestreams, news, mods and more.
    </h1>
    <div class="buttons">
        <a href="#how-to-play" class="btn btn-primary">How to play</a>
        <a href="#streams" class="btn btn-primary">Streams</a>
        <a href="#news" class="btn btn-primary">News</a>
    </div>
</div>
@endsection

@section('content')
<?php if($howToPlaySteps): ?>
<section id="how-to-play" class="section how-to-play">
    <div class="main-content">
        <h2 class="section-title">How to play {{ $category->title }}?</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>
        <div class="page-content">
            <?php print $howToPlaySteps; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section id="streams" class="section stream-listings">
    <div class="main-content">
        <?php if (count($streams) == 0): ?>
            <h2 class="section-title">Latest {{ $category->title }} videos</h2>
            <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
        <?php else: ?>
            <h2 class="section-title">{{ $category->title }} streamers</h2>
            <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
        <?php endif; ?>
    </div>
</section>

<section id="news" class="news-listings community-listings">
    <div class="main-content">
        <h2 class="section-title">{{ $category->title }} News</h2>
        <p class="section-description">
            Find the latest news for {{ $category->title }}. Lorem ipsum some other description etc.
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($news); ?>
        <div class="view-all">
            <a href="news/community-news" title="Community News" class="btn btn-primary">View all Community News</a>
        </div>
    </div>
</section>

@endsection
