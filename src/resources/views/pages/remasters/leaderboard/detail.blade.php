@extends('layouts.app')

@section('title', 'Online Leaderboard - Command & Conquer Remastered Collection')
@section('description', 'C&C Remastered Leaderboard, 1vs1')

@section('page-class', 'remasters remasters-leadeboard')

@section('hero-video')
<?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
<div class="content center">
    <div class="title">
    <a href="/command-and-conquer-remastered" title="C&C Remastered">
        <img src="/assets/images/logos/cnc-remastered-logo.png" alt="C&C Remaster Logo" />
    </a>
    </div>
    <h1 class="text-uppercase">
        C&amp;C Remastered Leaderboard for Tiberian Dawn &amp; Red Alert
    </h1>
</div>
@endsection

@section('content')
<section class="section section-black news-listings">
    <div class="main-content">
        <h2 class="section-title">Test</h2>
        <p class="section-description">
        </p>

        <?php foreach($raLeaderboard as $data): ?>
        <div>
            <h5 style="margin: 0;">
            Rank {{ $data->rank }} - {{ $data->player() }}
            </h5>
            <ul>
                <li>Wins {{ $data->wins }}</li>
                <li>Lost {{ $data->losses }}</li>
                <li>Points {{ $data->points }}</li>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</section>

@endsection