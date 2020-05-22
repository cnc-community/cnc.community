@extends('layouts.app')

@section('title', 'Remasters')
@section('page-class', 'Remasters')

@section('content')
<section class="funny-listings">
    <div class="main-content">
        <h1>Remasters</h1>
        <p>Page for remasters</p>
    </div>
</section>

<section class="news-listings">
    <div class="main-content">
        <h2 class="section-title">Workshop Items</h2>
        <p class="section-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incidid unt ut laborDuisrem ipsum dolod unt ut laborDuisrem ipsum dolod...
            iusmod tempor incidid unt ut laborDuisrem ipsum dolod...
        </p>

        <?php new App\Http\CustomView\Components\WorkShopListing($workShopItems); ?>
    </div>
</section>
@endsection
