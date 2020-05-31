@extends('layouts.app')

@section('title', $page->title)
@section('page-class', 'category theme-'.$slugCategory)
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
        {{ $page->description }}
    </p>
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
        <div class="page-content">
            <?php print $howToPlaySteps; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php $howToPlayVideo = App\ViewHelper::getCustomFieldContents($page->id, App\CustomFieldNames::HOW_TO_PLAY_VIDEO); ?>
<?php if($howToPlayVideo): ?>
<section class="section section-grey video-tutorial">
    <div class="main-content">
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
        <div class="page-content">
            <?php print $howToPlayHelp; ?>
        </div>
    </div>
</section>
<?php endif; ?>
@endsection
