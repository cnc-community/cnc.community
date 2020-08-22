@extends('api.leaderboard.player.layout')

@section('page-class', 'player-webview')

@section('content')

<div class="main-content" style="padding-left: 25px; padding-right: 25px;">
    <h1>C&amp;C Community Leaderboard Webview Generator</h1>
    <p>This page allows you create a personalised webview, perfect for embedding into OBS as a browser stream.</p>

    <h3>Configure</h3>
    <p>
        Below are some properties to customize your leaderboard rank. 
    </p>

    <form>
        <div class="form-layout">
            <div class="form-group">
                <label for="border">Border</label>
                <select id="border" class="form-control" name="border" onchange="this.form.submit()">
                    <option value="default" {{ $inputBorder == "default" ? "selected": ""}}>Default</option>
                    <option value="no-border" {{ $inputBorder == "no-border" ? "selected": ""}}>No Border</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">Theme</label>
                <select id="color" class="form-control" name="color" onchange="this.form.submit()">
                    <option value="red" {{ $inputColor == "red" ? "selected": ""}}>Red</option>
                    <option value="blue" {{ $inputColor == "blue" ? "selected": ""}}>Blue</option>
                    <option value="green" {{ $inputColor == "green" ? "selected": ""}}>Green</option>
                    <option value="purple" {{ $inputColor == "purple" ? "selected": ""}}>Purple</option>
                    <option value="pink" {{ $inputColor == "pink" ? "selected": ""}}>Pink</option>
                    <option value="teal" {{ $inputColor == "teal" ? "selected": ""}}>Teal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="layout">Layout</label>
                <select id="layout" class="form-control" name="layout" onchange="this.form.submit()">
                    <option value="default" {{ $inputLayout == "default" ? "selected": ""}}>Default</option>
                    <option value="space-between" {{ $inputLayout == "space-between" ? "selected": ""}}>Spaced Between</option>
                </select>
            </div>

            <div class="form-group">
                <label for="size">Size</label>
                <select id="size" class="form-control" name="size" onchange="this.form.submit()">
                    <option value="default" {{ $inputSize == "default" ? "selected": ""}}>Default</option>
                    <option value="lg" {{ $inputSize == "lg" ? "selected": ""}}>Large</option>
                    <option value="xl" {{ $inputSize == "xl" ? "selected": ""}}>XL</option>
                    <option value="xxl" {{ $inputSize == "xxl" ? "selected": ""}}>XXL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="branding">C&C Community Branding</label>
                <select id="branding" class="form-control" name="branding" onchange="this.form.submit()">
                    <option value="default" {{ $inputBranding == "default" ? "selected": ""}}>Default (Off)</option>
                    <option value="show-branding" {{ $inputBranding == "show-branding" ? "selected": ""}}>Show</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">Properties <small>Shift click to select multiple</small></label>
                <select id="color" class="form-control" name="properties[]" multiple onchange="this.form.submit()">
                <option value="name" <?php if (in_array("name", $properties)):?>selected<?php endif;?>>Name</option>
                <option value="badge" <?php if (in_array("badge", $properties)):?>selected<?php endif;?>>Badge</option>
                <option value="rank" <?php if (in_array("rank", $properties)):?>selected<?php endif;?>>Rank</option>
                <option value="wins" <?php if (in_array("wins", $properties)):?>selected<?php endif;?>>Wins</option>
                <option value="lost" <?php if (in_array("lost", $properties)):?>selected<?php endif;?>>Lost</option>
                <option value="points" <?php if (in_array("points", $properties)):?>selected<?php endif;?>>Points</option>
                <option value="played" <?php if (in_array("played", $properties)):?>selected<?php endif;?>>Played</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Generate</button>
    </form>

    <h3>Preview</h3>
    <p>
        Below is your generated preview. Copy the below URL into OBS Browser Source.
    </p>
    <div class="form-group">
        <label for="url">OBS URL - Copy this into your OBS Browser stream</label>
        <input id="url" type="text" value={{ $generatedUrl }} />
    </div>
    @include("api.leaderboard.player._profile")

    <script type="text/javascript">
  
    </script>
</div>
@endsection
