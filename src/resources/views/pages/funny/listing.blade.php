@extends('layouts.app')

@section('title', 'Funny')
@section('page-class', 'funny')

@section('content')
<section class="funny-listings">
    <div class="main-content">
    <h3>Funny/Cool</h3>
    <p>Funny or cool Command &amp; Conquer things</p>
        <?php new App\Http\CustomView\Components\NewsListing($funnyItems); ?>
    </div>
</section>
@endsection
