@extends('layouts.app')
@section('title', '404')
@section('hero-video')
    <div class="video" style="background-image: url('/assets/images/bg-grey.jpg')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1>
            <img src="{{ Vite::asset('resources/assets/images/404.gif') }}" alt="404 page not found image" />
        </h1>
        <p>
            I'm sorry Comrade General, I couldn't find that. Did you mean Premier Cherdenko?
        </p>
    </div>
@endsection
