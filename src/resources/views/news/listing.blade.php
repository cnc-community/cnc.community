@extends('layouts.app')

@section('title', $category->name)
@section('description', 'Stay up to date with our latest developments with ' . $category->name)

@section('hero-video')
    <div class="video" style="background-image: url('/{{ Vite::asset('resources/assets/images/bg-grey.jpg') }}')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1 class="text-uppercase">
            {{ $category->name }}
        </h1>

        <?php if($pageCategory): ?>
        <a href="{{ $pageCategory->url() }}" class="btn btn-primary">Back to {{ $pageCategory->title }}</a>
        <?php endif; ?>
    </div>
@endsection

@section('content')
    <section class="section section-grey news-listings">
        <div class="main-content">
            <?php new App\Http\CustomView\Components\NewsListing($news); ?>
            {{ $news->links() }}
        </div>
    </section>
@endsection
