@extends('layouts.app')

@section('content')
<div class="page-background" style="padding-top: 100px">
    <section class="top-ranks">
        <div class="main-content">
            <h1 class="text-uppercase">{{ $player->playerName() }}</h1>

            <div>
                Wins {{ $playerData->wins}} <br/>
                Lost {{ $playerData->losses}} <br/>
                Points {{ floor($playerData->points) }} <br/>
            </div>

            <h3>Recent games</h3>
            <div>
                @foreach($matches as $match)
                <strong>Map Name</strong>: {{ var_dump($match->mapname) }}
                <br>
                <strong>Colours</strong>: {{ var_dump($match->colors) }}
                <br>
                <strong>Factions</strong>: {{ var_dump($match->factions) }}
                <br>
                <strong>Teams</strong>: {{ var_dump($match->teams) }}
                <br>
                <strong>Locations</strong>: {{ var_dump($match->locations) }}
                <br>              
                <strong>Match Duration</strong>: {{ $match->matchduration }}
                <br>                
                <strong>Winning Team Id</strong>: {{ $match->winningteamid }}
                <br>               
                <strong>Player Ids</strong>: {{ var_dump($match->players) }}
                <br>
                <hr>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection