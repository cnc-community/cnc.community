@extends('layouts.app')

@section('title', $category->name)
@section('description', "Stay up to date with our latest developments with ". $category->name)

@section('hero')
<div class="content center">
    <h1>
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
        <h2 class="section-title">Official Intel</h2>
        <p class="section-description">
            C&C Community updates - stay up to date with our latest developments.
        </p>

        <?php new App\Http\CustomView\Components\NewsListing($news); ?>

        {{ $news->links() }}
    </div>
</section>
@endsection
