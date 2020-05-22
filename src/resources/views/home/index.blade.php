@extends('layouts.app')

@section('title', 'Home')
@section('page-class', 'homepage')

@section('hero')
<div class="content center">

    <div class="title">
        <img src="assets/images/logos/cnc-community-logo.png" alt="C&C Community Logo" />
    </div>
    {{-- <h1 class="title">Welcome to C&amp;C Community</h1> --}}
    <p class="lead">
        C&C Community details how to play all of the C&amp;C Games,
        shows the latest streams and news from all around the community.
    </p>
    <div class="buttons">
        <a class="btn btn-primary" href="#games">View Games</a>
        <a class="btn btn-primary" href="#news">View News</a>
    </div>
</div>
@endsection

@section('content')
<section id="games" class="how-to-guides">
    <div class="main-content">
        <h2 class="section-title">How to play <br class="hide-for-xs"/>Command &amp; Conquer</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>
    </div>
        
    <div class="guides">
        <?php new App\Http\CustomView\Components\GameSlider($__env); ?>
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
@endsection
