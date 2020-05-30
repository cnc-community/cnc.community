<?php $howToPlaySteps = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category theme-'.$category->slug)
@section('hero-class', 'hero-'. $category->slug)

@section('hero-video')
<?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
<div class="content center">
    <div class="title">
        <img src="{{ \App\ViewHelper::getGameLogoPathByName($category->slug) }}" alt="Game logo" />
    </div>
    <h1 class="small-h1">
        {{ $category->title }} lives on Commander. Will you join us? <br class="visible-md" />
        Discover the latest {{ $category->title }} livestreams, news, mods and more.
    </h1>
    <div class="buttons">
        <a href="{{ $category->slug}}/how-to-play" class="btn btn-primary" title="How to play {{ $category->title }}">How to play guide</a>
        <a href="#streams" class="btn btn-primary" title="{{ $category->title }} Streams">Streams</a>
        <a href="#news" class="btn btn-primary" title="{{ $category->title }} News">News</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section section-buy">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">How to play</span> <br /> {{ $category->title }}</h1>
                <p>
                    Follow our simple how to play guide for {{ $category->title }}.
                    Experience the amazing campaign or dive into multiplayer with thousands of others still playing online.
                </p>
                <div class="buttons">
                    <a class="btn btn-primary" title="How to play" href="{{ $category->slug}}/how-to-play">How to play guide</a>
                </div>
            </div>

            <div class="col-50 feature-text">
                <div class="feature-video">
                    <p>Watch the original {{ $category->title }} trailer...</p>
                    <div class="embed-iframe">
                        <iframe width="560" height="315" src="<?php echo \App\Constants::getYouTubeTrailerByGameSlug()[$category->slug]; ?>" 
                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
            Find the latest news from around the C&amp;C community for {{ $category->title }}, including mods, patches and much more.
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($news); ?>
    </div>
</section>

@endsection
