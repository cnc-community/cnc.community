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
    <h1 class="small-h1">
        Supporting our site
    </h1>
</div>
@endsection

@section('content')
<section class="section how-to-play-steps">
    <div class="main-content">
        <div class="page-content">
            <h1>Donations</h1>
            <p>
                All donations regardless of size are greatly appreciated by the C&amp;C Community team.
            </p>
            <p>
                There are a couple of options you can assign your donation towards:
                <ul>
                    <li><strong>To support site costs</strong> - This will be used towards keeping hosting and domain renewal costs down.</li>
                    <li><strong>To buy the team a beer</strong> - If you wish to thank the team for their work on the site, we'll split it between ourselves towards a 🍺!</li>
                </ul>
            </p>

            <p>
                <strong>As a donator</strong> please confirm in the additional Paypal notes if you are happy to be listed as a Donator on our Website and Discord channel. 
                Please include the name and your Discord username so we can add you.
            </p>

            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick" />
                <input type="hidden" name="hosted_button_id" value="YTXE2YT4CLMRY" />
                <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
            </form>
        </div>
    </div>
</section>
@endsection