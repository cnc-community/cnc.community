<?php 
$howToPlaySteps = App\ViewHelper::getCategoryCustomFieldContents(
        $category->id, 
        App\CustomFieldNames::HOW_TO_PLAY_STEPS
    ); 
?>
<?php 
    $heroDescription = App\ViewHelper::getCategoryCustomFieldContents(
        $category->id, 
        App\CustomFieldNames::HERO_DESCRIPTION
    ); 
?>
<?php 
    $howToPlayShortDescription = App\ViewHelper::getCategoryCustomFieldContents(
        $category->id, 
        App\CustomFieldNames::HOW_TO_PLAY_SHORT_DESCRIPTION
    ); 
?>
<?php 
    $quote = App\ViewHelper::getCategoryCustomFieldContents(
        $category->id, 
        App\CustomFieldNames::GAME_QUOTE
    ); 
?>

@extends('layouts.app')

@section('title', $category->title)

<?php if($heroDescription): ?>
@section('description', strip_tags($heroDescription))
<?php endif; ?>

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
    <?php if($heroDescription): ?>
        <?php print strip_tags($heroDescription, "<br>"); ?>
    <?php endif; ?>
    </h1>
    <div class="buttons">
        <a href="{{ $category->slug}}/how-to-play" class="btn btn-primary" title="How to play {{ $category->title }}">How to play</a>
        <a href="#streams" class="btn btn-primary" title="{{ $category->title }} Streams">Streams</a>
        <a href="#news" class="btn btn-primary" title="{{ $category->title }} News">News</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section section-grey section-buy">
    <div class="main-content center">
        <div class="feature-box">
            <div class="feature-text">
                <h1 class="section-title"><span class="light">How to play</span> <br /> {{ $category->title }}</h1>
                <p class="section-description">
                    <?php if($howToPlayShortDescription): ?>
                        <?php print strip_tags($howToPlayShortDescription, "<br>"); ?>
                    <?php endif; ?>
                </p>
                <div class="buttons">
                    <a class="btn btn-primary" title="How to play" href="/{{ $category->slug}}/how-to-play">How to play guide</a>
                </div>
            </div>

            <div class="feature-banner">
                <img src="{{ \App\ViewHelper::getFeatureBannerByGameSlug($category->slug) }}" alt="Game logo" />
                <div class="quote">
                    <?php if($quote): ?>
                        <?php print strip_tags($quote, "<p>,<br>"); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="streams" class="section section-black stream-listings">
    <div class="main-content">
        <?php if (count($streams) == 0): ?>
            <h2 class="section-title">Latest {{ $category->title }} videos</h2>
            <p>
                Discover the latest {{ $category->title }} video content on Twitch
            </p>
            <?php new App\Http\CustomView\Components\TwitchVideoListing($videos); ?>
        <?php else: ?>
            <h2 class="section-title">{{ $category->title }} streamers</h2>
            <?php new App\Http\CustomView\Components\TwitchListing($streams); ?>
        <?php endif; ?>
    </div>
</section>

<section id="news" class="section section-grey news-listings">
    <div class="main-content">
        <h2 class="section-title">{{ $category->title }} News</h2>
        <p class="section-description">
            Discover the latest {{ $category->title }} news from around the C&C community. Including patches, maps, mods and much more!
        </p>
        <?php new App\Http\CustomView\Components\NewsListing($news); ?>
    </div>
</section>

@endsection
