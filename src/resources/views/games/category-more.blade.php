<?php $howToPlaySteps = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category-more')
@section('hero-class', 'hero-' . $category->slug)

@section('hero-video')
    <?php $heroVideo = \App\Constants::getVideoWithPoster('command-and-conquer-4'); ?>
    <?php new \App\Http\CustomView\Components\VideoPlayer($heroVideo); ?>
@endsection

@section('hero')
    <div class="content center">
        <h1>
            {{ $category->title }}
        </h1>
        <p>
            Discover other Command &amp; Conquer games below!
        </p>
    </div>
@endsection

@section('content')
    <section id="buy" class="section section-grey section-buy">
        <div class="main-content center">
            <div class="items-wrap-old">

                @include('games.components.generic-box-item', [
                    'image' => 'resources/assets/images/more-cnc-games/ss.jpg',
                    'url' => 'https://cnc-comm.com/sole-survivor',
                    'title' => 'Command & Conquer: Sole Survivor',
                    'description' =>
                        'Sole Survivor was a unique multiplayer-only spin-off of Tiberian Dawn, where players controlled a single unit in a deathmatch-style game mode.',
                ])

                @include('games.components.generic-box-item', [
                    'image' => 'resources/assets/images/more-cnc-games/cnc4.jpg',
                    'url' => 'https://www.ea.com/games/command-and-conquer/command-and-conquer-4-tiberian-twilight',
                    'title' => 'Command & Conquer 4: Tiberian Twilight',
                    'description' => 'Tiberian Twilight is a real-time tactics game and is the final C&C game to be set in the Tiberian Universe.',
                ])

                @include('games.components.generic-box-item', [
                    'image' => 'resources/assets/images/more-cnc-games/ta.jpg',
                    'url' => 'https://www.ea.com/games/command-and-conquer/command-and-conquer-tiberium-alliances',
                    'title' => 'Command & Conquer: Tiberium Alliances',
                    'description' => 'Tiberium Alliances is a free-to-play, massively-multiplayer, online real-time strategy game for web browsers. ',
                ])

                @include('games.components.generic-box-item', [
                    'image' => 'resources/assets/images/more-cnc-games/rivals.jpg',
                    'url' => 'https://www.ea.com/games/command-and-conquer/command-and-conquer-rivals',
                    'title' => 'Command & Conquer: Rivals',
                    'description' => 'C&C Rivals is a free-to-play, competitive, multiplayer real-time strategy game for Android and IOS.',
                ])

            </div>
        </div>
    </section>

@endsection
