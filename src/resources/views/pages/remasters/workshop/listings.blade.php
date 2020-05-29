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
        <a href="/command-and-conquer-remastered" class="btn btn-primary">Back to C&C Remastered</a>
    </div>
</div>
@endsection

@section('content')
<section id="buy" class="section workshop-listings">
    <div class="main-content center">
        <h2 class="section-title">Top C&amp;C Red Alert Maps</h2>
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topRAMaps); ?>
        </div>
    </div>
</section>

<section class="section section-purple workshop-listings">
    <div class="main-content">
        <h2 class="section-title">Top C&amp;C Remastered Tiberian Dawn Maps</h2>
        
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topTDMaps); ?>
        </div>
    </div>
</section>

<section class="section section-purple workshop-listings">
    <div class="main-content">
        <h2 class="section-title">Top C&amp;C Remastered Red Alert Mods </h2>

        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topRAMods); ?>
        </div>
    </div>
</section>

<section class="section section-purple workshop-listings">
    <div class="main-content">
        <h2 class="section-title">Top C&amp;C Remastered Tiberian Dawn Mods </h2>
        
        <div class="workshop-items-wrap">
            <?php new App\Http\CustomView\Components\WorkShopListing($topTDMods); ?>
        </div>
    </div>
</section>

@endsection