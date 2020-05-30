@extends('layouts.app')

@section('title', $page->title)
@section('page-class', 'game-detail')

@section('hero-video')
<?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        {{ $page->title }}
    </h1>
    <p class="lead">
        {{ $page->description }}
    </p>
    <div class="buttons">
        <a href="{{ $page->category()->url() }}" class="btn btn-primary" title="Go to {{ $page->category()->title }}">
            View other {{ $page->category()->title }} tutorials
        </a>
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
        <div class="page-content">
            <?php print $howToPlaySteps; ?>
        </div>
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
        <div class="page-content center">
            <?php print $howToPlayVideo; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $howToPlayHelp = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_HELP); ?>
<?php if($howToPlayHelp): ?>
<section class="section how-to-play-help">
    <div class="main-content">
        <h2 class="section-title">Need help? Ask in these support channels.</h2>
        <div class="page-content">
            <?php print $howToPlayHelp; ?>
        </div>
    </div>
</section>
<?php endif; ?>
@endsection
