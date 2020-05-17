<?php $howToPlay = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_LISTINGS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category')
@section('hero-class', 'hero-'. $category->slug)

@section('hero')
<div class="video">
<video autoplay="true" muted src="https://media.contentapi.ea.com/content/dam/ea/command-conquer/remastered/videos/2020/03/ccrem-section-bg-video-deep-dive-trailer-darkened.mp4
"></video>
</div>
<div class="content center">
    <h1 class="text-uppercase">
        {{ $category->title }}
    </h1>
    <p class="lead">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
    </p>
    <div class="buttons">
        <a href="#how-to-play" class="btn btn-primary">How to play</a>
        <a href="#streams" class="btn btn-primary">Streams</a>
        <a href="#news" class="btn btn-primary">News</a>
    </div>
</div>
@endsection

@section('content')
<?php if($howToPlay): ?>
<section id="how-to-play" class="section how-to-play">
    <div class="main-content">
        <h2 class="section-title">How to play {{ $category->title }}?</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>

        <?php print $howToPlay; ?>
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
