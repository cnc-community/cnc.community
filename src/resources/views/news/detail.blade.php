@extends('layouts.app')

@section('title', $newsItem->title)
@section('description', strip_tags($newsItem->excerpt()))
@section('page-class', 'news-detail')

@section('hero-video')
<div class="video" style="background-image: url('/assets/images/bg-grey.jpg')">
</div>
@endsection

@section('hero')
<div class="content center">
    <h1 class="small-h1">
        {{ $newsItem->title }}
    </h1>
    <div class="meta-info">
        <div class="date">
            Posted <?php echo $newsItem->created_at->diffForHumans(); ?>
        </div>
        <div class="date">
            <?php echo $newsItem->readTime(); ?> read 
        </div>
        <div class="category">
            <?php echo $newsItem->primaryCategory()->name; ?>
        </div>
    </div>
</div>
@endsection


@section('content')
<section class="section how-to-play-steps">
    <div class="main-content">
        <div class="page-content">
            <?php if($newsItem->image): ?>
            <div class="page-image">
                <img src="/<?php echo $newsItem->image; ?>" alt="<?php echo $newsItem->title; ?>" />
            </div>
            <?php endif; ?>
            <?php print $newsItem->post; ?>
        </div>
    </div>
</section>
@endsection