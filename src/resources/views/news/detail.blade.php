@extends('layouts.app')

@section('title', $newsItem->title)
@section('description', strip_tags($newsItem->excerpt()))
@section('page-class', 'news-detail')

@section('hero-video')
    <div class="video" style="background-image: url('{{ Vite::asset('resources/assets/images/bg-grey.jpg') }}')"></div>
@endsection

@section('hero')
    <div class="content center">
        <h1 class="small-h1">
            {{ $newsItem->title }}
        </h1>
        <p>
            {{ $newsItem->excerpt() }}
        </p>
        <div class="meta-info">
            <div class="date">
                Posted <?php echo $newsItem->created_at->diffForHumans(); ?>
            </div>
            <div class="date">
                <?php if($newsItem->author()): ?>
                by <?php echo $newsItem->author()->name; ?>
                <?php endif; ?>
            </div>
            <div class="date">
                <?php echo $newsItem->readTime(); ?> read
            </div>
        </div>
        <div class="meta-info">
            <?php foreach($newsItem->categories() as $category): ?>
            <div class="category">
                <a href="/news/{{ $category->slug }}" title="{{ $category->name }}">
                    {{ $category->name }}
                </a>
            </div>
            <?php endforeach; ?>
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
