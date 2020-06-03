<?php $howToPlaySteps = App\ViewHelper::getCategoryCustomFieldContents($category->id, App\CustomFieldNames::HOW_TO_PLAY_STEPS); ?>

@extends('layouts.app')

@section('title', $category->title)
@section('page-class', 'category-more')
@section('hero-class', 'hero-'. $category->slug)

@section('hero')
<div class="content center">
    <h1>
        {{ $category->title }} 
    </h1>
    <p>
        Explore other C&amp;C games below! 
    </p>
</div>
@endsection

@section('content')
<section id="buy" class="section section-grey section-buy">
    <div class="main-content center">
        <div class="items-wrap">

            <?php new \App\Http\CustomView\Components\GenericBoxItem(
                $image = "/assets/images/more-cnc-games/ss.jpg",
                $url = "https://cnc.gamepedia.com/Command_%26_Conquer:_Sole_Survivor",
                $title = "Command &amp; Conquer: Sole Survivor",
                $description = "Sole Survivor is the 3rd and a largely forgotten C&C game. The game was similar to a top down shooter, however unlike a top down shooter your character controls more like a unit from Command & Conquer, by pointing and clicking, rather than the more traditional keyboard for movement and mouse for aiming control scheme."
            ); ?>

            <?php new \App\Http\CustomView\Components\GenericBoxItem(
                $image = "/assets/images/more-cnc-games/cnc4.jpg",
                $url = "https://store.steampowered.com/app/47700/Command__Conquer_4_Tiberian_Twilight/",
                $title = "Command &amp; Conquer 4: Tiberian Twilight",
                $description = "Command & Conquer 4: Tiberian Twilight is a real-time strategy video game, part of the Command & Conquer franchise, released March 16, 2010. It constitutes a final chapter in the Tiberium saga."
            ); ?>

            <?php new \App\Http\CustomView\Components\GenericBoxItem(
                $image = "/assets/images/more-cnc-games/ta.jpg",
                $url = "https://www.tiberiumalliances.com/home",
                $title = "Command &amp; Conquer: Tiberium Alliances",
                $description = "Command & Conquer: Tiberium Alliances is a military science fiction massively multiplayer online real-time strategy video game developed by Electronic Arts Phenomic and published by Electronic Arts as a free-to-play online-only browser game. Released 15th March 2012."
            ); ?>

             <?php new \App\Http\CustomView\Components\GenericBoxItem(
                $image = "/assets/images/more-cnc-games/rivals.jpg",
                $url = "https://www.ea.com/en-gb/games/command-and-conquer/command-and-conquer-rivals",
                $title = "Command &amp; Conquer: Rivals",
                $description = "Command & Conquer: Rivals is a free-to-play real-time strategy mobile game. The game was released on Android and iOS on December 4, 2018"
            ); ?>
        </div>
    </div>
</section>

@endsection