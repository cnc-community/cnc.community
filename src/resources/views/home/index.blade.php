@extends('layouts.app')

@section('title', 'Home')
@section('page-class', 'homepage')

@section('hero')
<div class="content center">
    <h1>Welcome Back Commander</h1>
    <p class="lead">
        Play C&amp;C on Windows 10 and get all of the <br class="hide-for-xs"/>latest news and content from the community.
    </p>
    <div class="buttons">
        <a class="btn btn-outline" href="#games">Discover C&amp;C</a>
        <a class="btn btn-outline" href="#mission">Our Mission</a>
    </div>
</div>
@endsection

@section('content')
<section id="games" class="how-to-guides">
    <div class="main-content">
        <h2 class="section-title">Discover <br class="hide-for-xs"/>Command &amp; Conquer</h2>
        <p class="section-description">
            Choose a game to find out how to play on Windows 10 and stay up to date with the latest news from around the community.
        </p>
    </div>
        
    <div class="guides">
        <?php new App\Http\CustomView\Components\GameSlider($__env); ?>
    </div>
</section>

<section id="tiberiandawn" class="section section-grey-alt cnc-remastered-introduction">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">C&amp;C Remastered </span> <br /> Has Launched!</h1>
                <p>
                    Developed alongside the C&amp;C Community, the Command & Conquer Remastered Collection Delivers 4K Graphics, 
                    Rebuilt Multiplayer, Enhanced UI, the Completely Remastered Legendary Soundtrack by Frank Klepacki and more.
                </p>
            </div>
            <div class="col-50 feature-logo">
                <img src="/assets/images/logos/cnc-remastered-logo.png" alt="Tiberian Dawn Remastered" />

                <div class="buttons">
                    <a href="/command-and-conquer-remastered/" class="btn btn-primary" title="Maps">View C&amp;C Remastered</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-black news-listings">
    <div class="main-content">
        <h2 class="section-title">C&amp;C Community News</h2>
        <p class="section-description">
            Discover the latest News from the C&amp;C Community Team.
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($officialNews); ?>
        <div class="view-all">
            <a href="news/official-news" title="Official News" class="btn btn-primary">View all Official News</a>
        </div>
    </div>
</section>

<section id="mission" class="section section-grey section-mission">
    <div class="main-content center">
        <div class="feature-box">
            <div class="feature-text">
                <h1 class="section-title">Our Mission</h1>
                <p class="section-description">
                    C&amp;C Community is an ongoing project that aims to improve the accessibility of the Command &amp; Conquer 
                    the franchise and celebrate the tireless efforts of the wider communities that keep the games alive with mods, 
                    video content, streams and compatibility patches for moderns operating systems.
                </p>
                <div class="buttons">
                    <a class="btn btn-primary" title="What is C&C Community?" href="/news/official-news/our-mission-what-is-cc-community">Read more</a>
                </div>
            </div>

            <div class="feature-banner">
                <img src="/assets/images/cnc-community.png" alt="C&C logo" />
            </div>
        </div>
    </div>
</section>
@endsection
