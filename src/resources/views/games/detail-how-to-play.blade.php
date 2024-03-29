@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)
@section('page-class', 'category theme-' . $slugCategory)
@section('page-class', 'game-detail')

@section('hero-video')
    <?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
    <div class="content center">
        <div class="title">
            <img src="{{ \App\ViewHelper::getGameLogoPathByName($slugCategory) }}" alt="Game logo" />
        </div>

        <h1 class="small-h1">
            <?php print strip_tags($page->description, '<br>'); ?>
        </h1>
        <div class="buttons">
            <a href="{{ $page->category()->url() }}" class="btn btn-primary" title="Go to {{ $page->category()->title }}">
                Go back to {{ $page->category()->title }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <?php $howToPlaySteps = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>
    <?php if($howToPlaySteps): ?>
    <section class="section how-to-play-steps">
        <div class="main-content">

            <div class="page-content-without-editor">
                <h2>Where to Buy {{ $page->category()->title }}</h2>
                <p>
                    You can now buy all of the classic Command & Conquer games digitally from either Steam or the EA App as part of The Ultimate Collection.
                </p>
                <div class="guide-buttons">
                    <a class="btn btn-outline btn-icon" title="Buy on Steam" rel="nofollow" href="https://store.steampowered.com/bundle/39394/">
                        Buy on Steam <i class="icon-steam"></i>
                    </a>
                    <a class="btn btn-outline btn-icon" title="Buy on EA Origin" rel="nofollow"
                        href="https://www.ea.com/games/command-and-conquer/command-and-conquer-the-ultimate-collection/buy/pc">
                        Buy on EA App <i class="icon-ea"></i>
                    </a>
                </div>
            </div>

            <div class="page-content page-content-with-editor">
                <?php print $howToPlaySteps; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php $howToPlayVideo = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_VIDEO); ?>
    <?php if($howToPlayVideo): ?>
    <section class="section section-grey video-tutorial">
        <div class="main-content">
            <div class="page-content page-content-with-editor">
                <h2>YouTube how to play steps</h2>
                <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php print strip_tags($howToPlayVideo); ?>" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php $howToPlayHelp = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_HELP); ?>
    <?php if($howToPlayHelp): ?>
    <section class="section how-to-play-help">
        <div class="main-content">
            <div class="page-content page-content-with-editor">
                <?php print $howToPlayHelp; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
@endsection
