@extends('layouts.app')

@section('title', 'C&C Memes')
@section('description', 'Today we will make history comrade! - Premier Romanov')
@section('page-class', 'funny')

@section('content')
<section class="funny-listings">
    <div class="main-content">
    <h1>Funny/Cool</h1>
    <p>Today we will make history comrade! - Premier Romanov</p>
    <?php new App\Http\CustomView\Components\NewsListing($funnyItems); ?>
    </div>
</section>
@endsection