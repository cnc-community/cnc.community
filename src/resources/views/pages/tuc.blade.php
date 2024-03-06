@extends('layouts.app')

@section('title', 'How to play the Command & Conquer Ultimate Collection on Steam')

@section('page-class', 'homepage')

@section('hero')
    <div class="feature-image-text">
        <div class="feature-image">
            <img src="/assets/images/tuc/tuc-logo.png" alt="C&C Ultimate Collection on Steam" />
        </div>
        <div class="feature-text">
            <div class="content">
                <h1>C&amp;C Ultimate Collection <br class="hide-for-xs" />Out Now On Steam</h1>
                <p>
                    Command &amp; Conquer™ The Ultimate Collection has been released on Steam!
                    Enjoy decades worth of Command & Conquer with 10 base games and 7 in-depth expansion packs.
                </p>
                <div class="buttons">
                    <a class="btn btn-secondary btn-icon" title="Buy on Steam" rel="nofollow" href="#">
                        Buy on Steam <i class="icon-steam"></i>
                    </a>
                    <a class="btn btn-secondary btn-icon" title="Buy on EA Origin" rel="nofollow" href="#">
                        Buy on EA App <i class="icon-ea"></i>
                    </a>
                </div>
            </div>
        </div>
    @endsection

    @section('content')
        <section id="games" class="how-to-guides">
            <div class="main-content">
                <h2 class="section-title">How To Play the Command and Conquer™ <br class="hide-for-xs" /> Ultimate Collection On Steam</h2>
                <p class="section-description">
                    Enjoy limitless hours of RTS Command & Conquer gaming with 10 base games and 7 in-depth expansion packs.
                    To purchase, <a href="#">Buy on Steam</a> or <a href="#">Buy on the EA App</a>.
                </p>
            </div>
        </section>

        <div class="page-content">
            <h3>Purchase the Command and Conquer™ <br class="hide-for-xs" /> Ultimate Collection</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation
                <strong>Send</strong> all the <strong>Help.</strong>
            </p>

            <p>
                <a href="#">Send Help Send Help Send Help.</a>
            </p>

            <h3>Pick from your steam library the game you want to play</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                veniam, quis nostrud exercitation.
            </p>
        </div>

        <div class="page-content" id="faq">
            <div>
                <h2>Frequently Asked Questions</h2>
            </div>
            <div>
                <h3>I need help.</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    veniam, quis nostrud exercitation.
                </p>
            </div>

            <div>
                <h3>Does online multiplayer work with Steam and the C&amp;C Ultimate Collection?</h3>
                <p>
                    Yes but not using the in-game menus. Simply pick the game below for a guide on how to play online with thousands of others using the trusted
                    community platforms; <a href="#">CnCNet</a>, <a href="#">W3DHub</a> and <a href="#">C&C:Online</a>
                </p>
            </div>
        </div>

        <section id="games" class="how-to-guides" style="padding-top:0; margin-top:0">
            <div class="guides">
                <?php new App\Http\CustomView\Components\GameSlider($__env); ?>
            </div>
        </section>
    @endsection
