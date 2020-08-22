@extends('api.leaderboard.player.layout')

@section('page-class', 'player-webview')

@section('content')
<div class="main-content">
    @include("api.leaderboard.player._profile")
</div>
@endsection
