<?php $whereToGetGames = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::WHERE_TO_GET_GAMES); ?>
<?php $howToPlay = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_LISTINGS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category')

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        {{ $category->title }}
    </h1>
    <p class="lead">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
    </p>
    <div class="buttons">

    </div>
</div>
@endsection

@section('content')
<?php if($whereToGetGames): ?>
<section class="section where-to-get">
    <div class="main-content">
        <h2 class="section-title">Where to get {{ $category->title }} ?</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>
        <?php print $whereToGetGames; ?>
        <div class="boxes">
            <a href="red-alert/campaign" class="box red-alert">
                <div class="description">
                    <h3 class="text-uppercase">
                        CnCNet
                    </h3>
                    <p>
                        Consectetur adipiscing elit, sed do eiusmod
                        tempor incidid unt
                    </p>
                </div>
            </a>
            <a href="red-alert/online" class="box red-alert">
                <div class="description">
                    <h3 class="text-uppercase">
                        Origin
                    </h3>
                    <p>
                        Consectetur adipiscing elit, sed do eiusmod
                        tempor incidid unt
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($howToPlay): ?>
<section class="section how-to-play">
    <div class="main-content">
        <h2 class="section-title">How to play {{ $category->title }} ?</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>

        <?php print $howToPlay; ?>
        <div class="boxes">
            <a href="red-alert/campaign" class="box red-alert">
                <div class="description">
                    <h3 class="text-uppercase">
                        Campaign
                    </h3>
                    <p>
                        Consectetur adipiscing elit, sed do eiusmod
                        tempor incidid unt
                    </p>
                </div>
            </a>
            <a href="red-alert/online" class="box red-alert">
                <div class="description">
                    <h3 class="text-uppercase">
                        Online
                    </h3>
                    <p>
                        Consectetur adipiscing elit, sed do eiusmod
                        tempor incidid unt
                    </p>
                </div>
            </a>
            <a href="red-alert/crossplay" class="box red-alert">
                <div class="description">
                    <h3 class="text-uppercase">
                        Crossplay
                    </h3>
                    <p>
                        Consectetur adipiscing elit, sed do eiusmod
                        tempor incidid unt
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

@endsection
