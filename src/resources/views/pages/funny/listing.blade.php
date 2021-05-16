@extends('layouts.app')

@section('title', 'C&C Memes')
@section('description', 'Today we will make history comrade! - Premier Romanov')
@section('page-class', 'funny')

@section('hero-video')
<div class="video" style="background-image: url('/assets/images/bg-grey.jpg')">
</div>
@endsection

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        Funny/Cool
    </h1>
    <p class="lead">
        Today we will make history comrade! - Premier Romanov
    </p>
</div>
@endsection

@section('content')
<section class="funny-listings">
    <div class="main-content">

        <?php new App\Http\CustomView\Components\NewsListing($funnyItems); ?>

        {{ $funnyItems->links() }}
    </div>
</section>
@endsection