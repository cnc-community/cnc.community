@extends('layouts.app')

@section('title', $category->title)
@section('page-class', '')
@section('page-class', 'page-generic news-detail')

@section('hero-video')
    <div class="video" style="background-image: url('/assets/images/bg-grey.jpg')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1>
            {{ $category->title }}
        </h1>
    </div>
@endsection

@section('content')
    <?php $genericPageContents = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::GENERIC_PAGE); ?>
    <?php if($genericPageContents): ?>
    <section class="section how-to-play-steps">
        <div class="main-content">
            <div class="page-content">
                <?php print $genericPageContents; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
@endsection
