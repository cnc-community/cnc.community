@extends('layouts.app')

@section('title', 'Home')
@section('page-class', 'homepage')

@section('hero')
<div class="content center">

    {{-- <div class="title">
        <img src="assets/images/logos/cnc-community-logo.png" alt="C&C Community Logo" />
    </div> --}}
    <h1>Welcome to C&amp;C Community</h1>
    <p class="lead">
        Stay current with C&amp;C Games and their communities. 
    </p>
    <div class="buttons">
        <a class="btn btn-outline" href="#games">How to Play C&C</a>
        <a class="btn btn-outline" href="#mission">Our Mission</a>
    </div>
</div>
@endsection

@section('content')
<section id="games" class="how-to-guides">
    <div class="main-content">
        <h2 class="section-title">How to play <br class="hide-for-xs"/>Command &amp; Conquer</h2>
        <p class="section-description">
            Each game has it's own designated page of the latest news, live streams and a tutorial on how to play.
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
            C&C Community updates - stay up to date with our latest developments.
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($officialNews); ?>
        <div class="view-all">
            <a href="news/official-news" title="Official News" class="btn btn-primary">View all Official News</a>
        </div>
    </div>
</section>

<section id="mission" class="section news-listings">
    <div class="main-content center">
        <h2 class="section-title">Our Mission</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>
    </div>
</section>
@endsection
