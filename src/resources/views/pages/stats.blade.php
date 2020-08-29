@extends('layouts.app')

@section('title', 'Supporting the C&C Community team and website')
@section('description', 'All donations regardless of size are greatly appreciated in keeping the costs down on our website.')
@section('page-class', 'donate')


@section('hero-video')
<div class="video" style="background-image: url('/assets/images/creators.jpg')">
</div>
@endsection

@section('hero')
<div class="content center">
    <h1 class="text-uppercase">
        C&amp;C Games Statistics
    </h1>
    <p class="lead">
        <strong>{{ $onlineCounts["total"] }}</strong> players online C&amp;C Games &amp; mods
    </p>
</div>
@endsection

@section('content')
<section class="section how-to-play-steps">
    <div class="main-content">
        <div class="items-wrap">
            <?php foreach($onlineCounts as $abrev => $onlineCount) :?>
                <?php if($abrev == "total") continue; ?>
                
                <?php $game = App\Constants::getGameFromOnlineAbbreviation($abrev); ?>

                <a href="{{  $game["url"] }}" <?php if($game["external_link"] == true):?> 
                            target="_blank" rel="nofollow noreferrer"<?php endif; ?> 
                            title="{{ $game["name"] }}" class="stat-game-box stat-game--image-{{ $abrev }}">

                    <div class="stat-game-box-logo">
                        <img src="{{ $game["logo"]}}" alt="Game Logo" />
                    </div>
                    <div class="stat-game-online-count">
                        <?php if($onlineCount > 0 ) :?>
                            <strong>{{ $onlineCount }} online</strong> 
                        <?php endif; ?>
                        <br/> {{ $game["name"] }}
                        <br/>
                        <?php if($abrev == "cncremastered"):?>
                            <small>In-game (Steam only)</small>
                        <?php endif; ?>
                    </div>
                </a>

            <?php endforeach; ?>
        </div>
    </div>
</section>
@endsection