<?php $howToPlay = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_LISTINGS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category')
@section('hero-class', 'hero-red hero-ra')

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        {{ $category->title }}
    </h1>
    <p class="lead">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
    </p>
    <div class="buttons">
        <a href="#where-to-get" class="btn btn-primary">Where to get</a>
        <a href="#how-to-play" class="btn btn-primary">How to play</a>
    </div>
</div>
@endsection

@section('content')
<?php if($howToPlay): ?>
<section id="how-to-play" class="section how-to-play">
    <div class="main-content">
        <h2 class="section-title">How to play {{ $category->title }}?</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt
        </p>

        <?php print $howToPlay; ?>
    </div>
</section>
<?php endif; ?>

@endsection
