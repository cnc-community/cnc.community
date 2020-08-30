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
        <h3>C&amp;C Titles Players Online</h3>
        <div class="items-wrap">
            <?php foreach($onlineCounts["games"] as $abrev => $onlineCount) :?>
                <?php if($abrev == "total") continue; ?>
                
                <?php $game = App\Constants::getGameFromOnlineAbbreviation($abrev); ?>

                <?php new App\Http\CustomView\Components\OnlineBox(
                    $title = $game["name"], 
                    $url = $game["url"], 
                    $logo = $game["logo"], 
                    $externalLink = $game["external_link"], 
                    $gameAbrev = $abrev, 
                    $onlineCount = $onlineCount
                ); ?>

            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-content">
        <h3>C&amp;C Mods Players Online</h3>
        <div class="items-wrap">
            <?php foreach($onlineCounts["mods"] as $abrev => $onlineCount) :?>
                <?php if($abrev == "total") continue; ?>
                
                <?php $game = App\Constants::getGameFromOnlineAbbreviation($abrev); ?>

                <?php new App\Http\CustomView\Components\OnlineBox(
                    $title = $game["name"], 
                    $url = $game["url"], 
                    $logo = $game["logo"], 
                    $externalLink = $game["external_link"], 
                    $gameAbrev = $abrev, 
                    $onlineCount = $onlineCount
                ); ?>

            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-content">
        <h3>C&amp;C Standalones Players Online</h3>
        <div class="items-wrap">
            <?php foreach($onlineCounts["standalone"] as $abrev => $onlineCount) :?>
                <?php if($abrev == "total") continue; ?>
                
                <?php $game = App\Constants::getGameFromOnlineAbbreviation($abrev); ?>

                <?php new App\Http\CustomView\Components\OnlineBox(
                    $title = $game["name"], 
                    $url = $game["url"], 
                    $logo = $game["logo"], 
                    $externalLink = $game["external_link"], 
                    $gameAbrev = $abrev, 
                    $onlineCount = $onlineCount
                ); ?>

            <?php endforeach; ?>
        </div>
    </div>
</section>
@endsection

