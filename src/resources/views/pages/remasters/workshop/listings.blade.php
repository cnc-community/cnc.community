@extends('layouts.app')

@section('title', 'Steam WorkShop - Mods - Maps - Command & Conquer Remastered Collection')
@section('page-class', 'remasters remasters-mods')

@section('hero-video')
<?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
<div class="content center">
    <div class="title">
        <img src="/assets/images/logos/cnc-remastered-logo.png" alt="C&C Remaster Logo" />
    </div>
    <h1 class="text-uppercase">
        Steam WorkShop, Mods and Maps
    </h1>
    <div class="buttons">
        <a href="/command-and-conquer-remastered/workshop-mods#tiberiandawn" class="btn btn-primary">Tiberian Dawn Remastered</a>
        <a href="/command-and-conquer-remastered/workshop-mods#redalert" class="btn btn-primary">Red Alert Remastered</a>
    </div>
</div>
@endsection

@section('content')
<section id="tiberiandawn" class="section section-grey workshop-introduction">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">Play Remastered</span> <br /> Tiberian Dawn Maps &amp; Mods</h1>
                <p>
                    Find a map or mod you like below. <br class="hidden-xs" />
                    Open the link and click the Subscribe button 
                    for it to appear in game.
                </p>
            </div>
            <div class="col-50 feature-logo">
                <img src="/assets/images/logos/tiberian-dawn-remastered.png" alt="Tiberian Dawn Remastered" />
                <div class="buttons">
                    <a href="/command-and-conquer-remastered/workshop-mods#tdmods" class="btn btn-primary" title="Maps">Go to Mods</a>
                    <a href="/command-and-conquer-remastered/workshop-mods#TiberianDawnMaps" class="btn btn-primary" title="Mods">Go to Maps</a>
                </div>
            </div>
        </div>
    </div>

    <div id="TiberianDawnMaps" class="main-content center">
        <h2 class="section-title">Tiberian Dawn Maps <span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topTiberianDawnMaps); ?>
        </div>
    </div>

    <div id="tdmods" class="main-content center">
        <h2 class="section-title">Tiberian Dawn Mods  <span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topTDMods); ?>
        </div>
    </div>
</section>


<section id="redalert" class="section section-grey workshop-introduction">
    <div class="main-content center">
        <div class="feature-box">
            <div class="col-50 feature-text">
                <h1 class="section-title"><span class="light">Play Remastered</span> <br /> Red Alert Maps &amp; Mods</h1>
                <p>
                    Find a map or mod you like below. <br class="hidden-xs" />
                    Open the link and click the Subscribe button 
                    for it to appear in game.
                </p>
            </div>
            <div class="col-50 feature-logo">
                <img src="/assets/images/logos/red-alert-remastered.png" alt="Red Alert Remastered" />
                <div class="buttons">
                    <a href="/command-and-conquer-remastered/workshop-mods#ramods" class="btn btn-primary btn-theme-red" title="Maps">Go to Mods</a>
                    <a href="/command-and-conquer-remastered/workshop-mods#RedAlertMaps" class="btn btn-primary btn-theme-red" title="Mods">Go to Maps</a>
                </div>
            </div>
        </div>
    </div>

    <div id="RedAlertMaps" class="main-content center">
        <h2 class="section-title">Red Alert Maps <span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topRedAlertMaps); ?>
        </div>
    </div>

    <div id="ramods" class="main-content center">
        <h2 class="section-title">Red Alert Mods  <span class="grey">Trending this week</span></h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topRAMods); ?>
        </div>
    </div>
</section>


@endsection