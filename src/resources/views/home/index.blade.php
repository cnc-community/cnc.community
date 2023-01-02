@extends('layouts.app')

@section('title', 'How to play C&C guides, C&C News, C&C Remastered Leaderboards')

@section('page-class', 'homepage')

@section('hero')
    <div class="content center">
        <h1>Welcome Back Commander</h1>
        <p class="lead">
            Play C&amp;C on Windows 10 and get all of the <br class="hide-for-xs" />latest news and content from the
            community.
        </p>
        <div class="buttons">
            <a class="btn btn-secondary" href="#games" title="Discover C&C">Discover C&amp;C</a>
            <a class="btn btn-secondary" href="#mission" title="Our Mission">Our Mission</a>
        </div>
    </div>
@endsection

@section('content')
    <section id="games" class="how-to-guides">
        <div class="main-content">
            <h2 class="section-title">Discover <br class="hide-for-xs" />Command &amp; Conquer</h2>
            <p class="section-description">
                Choose a game to find out how to play on Windows 10 and stay up to date with the latest news from around the
                community.
            </p>
        </div>

        <div class="guides">
            <?php new App\Http\CustomView\Components\GameSlider($__env); ?>
        </div>
    </section>

    <section id="leaderboards" class="section section-black-alt leaderboard-introduction">
        <div class="main-content center">
            <div class="feature-box">
                <div class="col-50 feature-text">
                    <h1 class="section-title"><span class="light">Command &amp; Conquer Remastered</span> Leaderboards</h1>
                    <p class="section-description">
                        Find the elite in our new Command &amp; Conquer Remastered Leaderboards for Tiberian Dawn and Red
                        Alert.
                    </p>
                    <div class="buttons">
                        <a href="/command-and-conquer-remastered/leaderboard" class="btn btn-secondary"
                            title="View All Leaderboards">View Leaderboards</a>
                    </div>
                </div>

                <div class="col-50 feature-banner">
                    <img src="/assets/images/leaderboard-promo.jpg" alt="Leaderboard" loading="lazy" />
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
                        C&amp;C Community is an ongoing project that aims to improve the accessibility of the Command &amp;
                        Conquer
                        the franchise and celebrate the tireless efforts of the wider communities that keep the games alive
                        with mods,
                        video content, streams and compatibility patches for moderns operating systems.
                    </p>
                    <div class="buttons">
                        <a class="btn btn-primary" title="What is C&C Community?"
                            href="/news/official-news/our-mission">Read more</a>
                    </div>
                </div>

                <div class="feature-banner">
                    <img src="/assets/images/cnc-community.png" alt="C&C logo" loading="lazy" />
                </div>
            </div>
        </div>
    </section>

    <section id="partners" class="section section-dark-grey section-sites">
        <div class="main-content text-center">
            <h2 class="section-title">Affiliates</h2>
        </div>

        <div class="sites">
            <?php new App\Http\CustomView\Components\Sites(); ?>
        </div>
    </section>
@endsection
