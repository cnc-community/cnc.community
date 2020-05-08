@extends('layouts.app')

@section('title', 'Home')
@section('page-class', 'homepage')

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        C&amp;C Community Headline
    </h1>
    <p class="lead">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
        Lorem ipsum dolor sit amet, consi.
    </p>
    <button class="btn btn-primary">Primary CTA</button>
</div>
@endsection

@section('content')
<section class="how-to-guides">
    <div class="main-content">
        <h2 class="section-title">How to play <br class="hide-for-xs"/>Command &amp; Conquer</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>
    </div>
        
    <div class="guides">
        <?php new App\Http\CustomView\Components\Swiper($__env); ?>
    </div>
</section>

<section class="news-listings">
    <div class="main-content">
        <h2 class="section-title">Official Intel</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($officialNews); ?>
        <div class="view-all">
            <a href="news/official-news" title="Official News" class="btn btn-primary">View all Official News</a>
        </div>
    </div>
</section>

<section class="news-listings community-listings">
    <div class="main-content">
        <h2 class="section-title">Community Intel</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($communityNews); ?>
        <div class="view-all">
            <a href="news/community-news" title="Community News" class="btn btn-primary">View all Community News</a>
        </div>
    </div>
</section>
@endsection
