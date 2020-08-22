@extends('api.leaderboard.player.layout')

@section('page-class', 'player-webview')

@section('content')
<div class="main-content" style="padding-left: 25px; padding-right: 25px;">


    <form style="width: 400px;max-width: 100%;">
        <div class="form-group">
            <label for="border">Border</label>
            <select id="border" class="form-control" name="border" >
                <option value="default" {{ $inputBorder == "default" ? "selected": ""}}>Default</option>
                <option value="no-border" {{ $inputBorder == "no-border" ? "selected": ""}}>No Border</option>
            </select>
        </div>

        <div class="form-group">
            <label for="color">Theme</label>
            <select id="color" class="form-control" name="color" >
                <option value="red" {{ $inputColor == "red" ? "selected": ""}}>Red</option>
                <option value="blue" {{ $inputColor == "blue" ? "selected": ""}}>Blue</option>
                <option value="pink" {{ $inputColor == "pink" ? "selected": ""}}>Pink</option>
                <option value="teal" {{ $inputColor == "teal" ? "selected": ""}}>Teal</option>
            </select>
        </div>

        <div class="form-group">
            <label for="layout">Layout</label>
            <select id="layout" class="form-control" name="layout">
                <option value="default" {{ $inputLayout == "default" ? "selected": ""}}>Default</option>
                <option value="space-between" {{ $inputLayout == "space-between" ? "selected": ""}}>Spaced Between</option>
            </select>
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <select id="size" class="form-control" name="size">
                <option value="default" {{ $inputSize == "default" ? "selected": ""}}>Default</option>
                <option value="lg" {{ $inputSize == "lg" ? "selected": ""}}>Large</option>
                <option value="xl" {{ $inputSize == "xl" ? "selected": ""}}>XL</option>
                <option value="xxl" {{ $inputSize == "xxl" ? "selected": ""}}>XXL</option>
            </select>
        </div>

        <div class="form-group">
            <label for="color">Properties</label>
            <select id="color" class="form-control" name="properties[]" multiple>
               <option value="badge" <?php if (in_array("badge", $properties)):?>selected<?php endif;?>>Badge</option>
               <option value="rank" <?php if (in_array("rank", $properties)):?>selected<?php endif;?>>Rank</option>
               <option value="wins" <?php if (in_array("wins", $properties)):?>selected<?php endif;?>>Wins</option>
               <option value="lost" <?php if (in_array("lost", $properties)):?>selected<?php endif;?>>Lost</option>
               <option value="points" <?php if (in_array("points", $properties)):?>selected<?php endif;?>>Points</option>
               <option value="played" <?php if (in_array("played", $properties)):?>selected<?php endif;?>>Played</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Generate</button>
    </form>

    <h3>Preview</h3>
    @include("api.leaderboard.player._profile")

    <script type="text/javascript">
  
    </script>
</div>
@endsection
