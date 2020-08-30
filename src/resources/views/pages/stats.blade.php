@extends('layouts.app')

@section('title', 'C&C Games Statistics')
@section('description', 'Find all the official C&C Online and C&C Community online game statistics')
@section('page-class', 'game-stats')


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
        <strong><span class="js-total-online"></span></strong> players online C&amp;C Games &amp; mods
    </p>
</div>
@endsection

@section('content')
<section class="section how-to-play-steps">
    <div class="main-content">
        <h3>Official C&amp;C Titles - Players Online</h3>
        <div class="items-wrap">
            <?php foreach($games as $game) :?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php 
                    new App\Http\CustomView\Components\OnlineBox(
                        $title = $gameByAbbreviation["name"], 
                        $url = $gameByAbbreviation["url"], 
                        $logo = $gameByAbbreviation["logo"], 
                        $externalLink = $gameByAbbreviation["external_link"], 
                        $gameAbrev = $game->getAbbreviation(), 
                        $onlineCount = $game->getOnlineCount()
                    ); 
                ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-content">
        <h3>C&amp;C Mods - Players Online</h3>
        <div class="items-wrap">
            <?php foreach($mods as $game) :?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php 
                    new App\Http\CustomView\Components\OnlineBox(
                        $title = $gameByAbbreviation["name"], 
                        $url = $gameByAbbreviation["url"], 
                        $logo = $gameByAbbreviation["logo"], 
                        $externalLink = $gameByAbbreviation["external_link"], 
                        $gameAbrev = $game->getAbbreviation(), 
                        $onlineCount = $game->getOnlineCount()
                    ); 
                ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-content">
        <h3>C&amp;C Community Games - Players Online</h3>
        <div class="items-wrap">
            <?php foreach($standalone as $game) :?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php 
                    new App\Http\CustomView\Components\OnlineBox(
                        $title = $gameByAbbreviation["name"], 
                        $url = $gameByAbbreviation["url"], 
                        $logo = $gameByAbbreviation["logo"], 
                        $externalLink = $gameByAbbreviation["external_link"], 
                        $gameAbrev = $game->getAbbreviation(), 
                        $onlineCount = $game->getOnlineCount()
                    ); 
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
@endsection

