@extends('api.leaderboard.player.layout')

@section('page-class', 'player-webview')

@section('content')
<div class="main-content">
    @include("api.leaderboard.player._profile")
</div>
<script>
    setTimeout(function ()
    {
        document.location.reload();
    }, 900000); // 15 minutes
</script>
@endsection
