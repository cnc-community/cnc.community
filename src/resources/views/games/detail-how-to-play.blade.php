@extends('layouts.app')

@section('title', $page->title)
@section('page-class', 'game-detail')

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        {{ $page->title }}
    </h1>
    <p class="lead">
        {{ $page->description }}
    </p>
    <div class="buttons">
        <a href="#where-to-get" class="btn btn-primary">Where to get</a>
        <a href="#how-to-play" class="btn btn-primary">How to play</a>
    </div>
</div>
@endsection

@section('content')
<?php $howToPlaySteps = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>
<?php if($howToPlaySteps): ?>
<section class="section how-to-play-steps">
    <div class="main-content">
        <h2 class="section-title">Step by step instructions</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod
            tempor incidid unt
        </p>
        <?php print $howToPlaySteps; ?>
    </div>
</section>
<?php endif; ?>

<?php $howToPlayVideo = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_VIDEO); ?>
<?php if($howToPlayVideo): ?>
<section class="section video-tutorial">
    <div class="main-content">
        <h2 class="section-title">Watch the video tutorial</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod
            tempor incidid unt
        </p>
        <?php print $howToPlayVideo; ?>
    </div>
</section>
<?php endif; ?>

<?php $howToPlayHelp = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_HELP); ?>
<?php if($howToPlayHelp): ?>
<section class="section how-to-play-help">
    <div class="main-content">
        <h2 class="section-title">Need help? Ask in these support channels.</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod
            tempor incidid unt
        </p>
        <?php print $howToPlayHelp; ?>
    </div>
</section>
<?php endif; ?>
@endsection
