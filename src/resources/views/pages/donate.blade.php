@extends('layouts.app')

@section('title', 'Supporting the C&C Community team and website')
@section('description', 'All donations regardless of size are greatly appreciated in keeping the costs down on our website.')
@section('page-class', 'donate')

@section('hero-video')
    <div class="video" style="background-image: url('{{ Vite::asset('resources/assets/images/creators.jpg') }} ')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1 class="small-h1">
            Supporting the C&amp;C Community team and website
        </h1>
    </div>
@endsection

@section('content')
    <section class="section how-to-play-steps">
        <div class="main-content">
            <div class="page-content">
                <h1>Donations</h1>
                <p>
                    All donations regardless of size are greatly appreciated by the C&amp;C Community team and will help us to keep the site going for the
                    foreseeable future.
                </p>
                <p>
                    We've provided a couple of options that you can assign your donation towards:
                <ul>
                    <li><strong>To support site costs</strong> - This will be used towards keeping hosting and domain renewal costs down.</li>
                    <li><strong>To buy the team a beer</strong> - If you wish to thank the team for their work on the site,
                        we'll split it between ourselves towards a 🍺 fund.</li>
                </ul>
                </p>

                <p>
                    <strong>As a donator</strong> please confirm in the additional Paypal notes if you are happy to be listed as a Donator on our Website and
                    Discord channel.
                    Please include the name and your Discord username so we can add you.
                </p>

                <form action="https://www.paypal.com/donate" method="post" target="_top">
                    <input type="hidden" name="hosted_button_id" value="AL7RN2VVR36EE" />
                    <input type="image" src="https://i.imgur.com/p4ckBcs.png" border="0" name="submit" title="PayPal - The safer, easier way to pay online!"
                        alt="Donate with PayPal button" />
                    <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
                </form>
            </div>

            <div class="page-content">
                <h1>Donators</h1>
                <p>
                    Thanks for keeping the C&amp;C Community website going!
                </p>
                <ul>
                    <li>Chronostorm</li>
                    <li>[CNC] PlagueNXC</li>
                    <li>eksmad</li>
                    <li>Salem H.A</li>
                    <li>Tiberiansun292</li>
                    <li>Monopoxie</li>
                    <li>The Crazy Psychopath</li>
                    <li>Dino M</li>
                    <li>Frank G</li>
                    <li>Lee W.</li>
                    <li>Daniel Z</li>
                    <li>Dominique K</li>
                    <li>Isa Y</li>
                    <li>Caloy P</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
