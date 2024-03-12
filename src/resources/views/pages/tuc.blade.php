@extends('layouts.app')

@section('title', 'How to play the Command & Conquer Ultimate Collection on Steam')

@section('page-class', 'homepage')

@section('hero')
    <div class="feature-image-text">
        <div class="feature-image">
            <img src="{{ Vite::asset('resources/assets/images/tuc/tuc-logo.png') }}" alt="C&C Ultimate Collection on Steam" />
        </div>
        <div class="feature-text">
            <div class="content">
                <h1>C&amp;C Ultimate Collection <br class="hide-for-xs" />Now On Steam</h1>
                <p>
                    The Command & Conquer Ultimate Collection is now available on Steam and the EA App. From the classic Tiberium Saga to the alternate universe of
                    Red Alert to the modern warfare of Generals, this must-have compilation delivers a Command & Conquer experience like no other.
                </p>
                <div class="buttons">

                    <a class="btn btn-secondary btn-icon" href="{{ route('pages.tucMultiplayer') }}" title="How to play C&amp;C Ultimate Collection Online">
                        Play Online <i class="icon-right"></i>
                    </a>

                    <a class="btn btn-secondary btn-icon" title="Buy on Steam" rel="nofollow" href="{{ \App\Constants::getTUCSteamPageUrl() }}">
                        Buy on Steam <i class="icon-steam"></i>
                    </a>
                    <a class="btn btn-secondary btn-icon" title="Buy on EA Origin" rel="nofollow" href="{{ \App\Constants::getTUCEAPageUrl() }}">
                        Buy on EA App <i class="icon-ea"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="games" class="how-to-guides">
        <div class="main-content">
            <h2 class="section-title">How To Play Command and Conquer <br class="hide-for-xs" /> Ultimate Collection</h2>
            <p class="section-description" style="width:750px;max-width:100%;">
                Rediscover the groundbreaking, action-packed strategy gameplay that changed PC gaming forever. The Command & Conquer Ultimate Collection is the
                definintive compliation of the best-selling Real-Time Strategy franchise of all time, containing 10 base games and 7 in-depth expansion packs.
            </p>
        </div>
    </section>

    <div class="page-content">

        <h3>Purchase the Command &amp; Conquer Ultimate Collection</h3>
        <p>
            Purchase the Ultimate Collection on either Steam or the EA App to play the classic C&C games in all their glory!
        </p>
        <p>
            <a title="Buy on Steam" rel="nofollow" href="{{ \App\Constants::getTUCSteamPageUrl() }}">
                Buy on Steam
            </a>
            {{ ',' }}
            <a title="Buy on EA Origin" rel="nofollow" href="{{ \App\Constants::getTUCEAPageUrl() }}">
                Buy on EA App
            </a>
        </p>

        <h3>Check out our how-to guides</h3>
        <p>
            Take a look at our how-to guides to get the latest info on running the C&C ultimate collection at peak performance on Windows 10 and Windows 11.
        </p>

        <h3>How to Play Online</h3>
        <p>
            View our how-to guides on how to play the C&C ultimate collection online.
            <br class="hide-for-xs" />
            <a href="{{ route('pages.tucMultiplayer') }}" title="How to play C&amp;C Ultimate Collection Online">
                How to Play Online Guides
            </a>
        </p>
    </div>

    <section id="games" class="how-to-guides" style="padding-top:0; margin-top:0">
        <div class="main-content">
            <h2 class="section-title">How To Play Guides</h2>
        </div>

        <div class="guides">
            <?php new App\Http\CustomView\Components\GameSlider($__env); ?>
        </div>
    </section>

    <div class="page-content" id="faq">
        <div>
            <h2>Frequently Asked Questions</h2>
        </div>
        <div style="margin-bottom:40px;">
            <h3>My Game Won't Run</h3>
            <p>
                For all problems relating to the Ultimate Collection, please post information about your issue to the following
                community depending on which game you're having problems with.
            </p>
            <p>
            <ul class="list-styled">
                <li>Tiberian Dawn, Red Alert, Tiberian Sun, Red Alert 2/Yuri's Revenge - <a href="https://cncnet.org" rel="nofollow">CnCNet</a></li>
                <li>Renegade - <a href="https://w3dhub.com" rel="nofollow">W3D Hub</a></li>
                <li>Generals, Tiberium Wars, Red Alert 3 - <a href="https://cnc-online.net/" rel="nofollow">C&amp;C Online</a></li>
            </ul>
            </p>
            <p>
                For general queries head to the <a href="https://discord.com/invite/zktcZQY" rel="nofollow">C&C Community Discord</a>
            </p>
        </div>

        <div>
            <h3>Does online multiplayer work with Steam and the C&amp;C Ultimate Collection?</h3>
            <p>
                Yes. Simply pick the game below for a guide on how to play online with thousands of others using the trusted
                community platforms. <a href="#">CnCNet</a>, <a href="#">W3DHub</a> and <a href="#">C&C:Online</a>
            </p>
            <ul class="list-styled">
                <li>
                    <a href="tiberian-dawn/how-to-play">Tiberian Dawn</a>, <a href="red-alert/how-to-play">Red Alert</a>, <a
                        href="tiberian-sun/how-to-play">Tiberian Sun</a>, <a href="red-alert-2/how-to-play">Red Alert 2/Yuri's Revenge</a>
                </li>
                <li>
                    <a href="renegade/how-to-play">Renegade</a>
                </li>
                <li>
                    <a href="generals/how-to-play">Generals</a>, <a href="command-and-conquer-3/how-to-play">Tiberium Wars</a>, <a
                        href="red-alert-3/how-to-play">Red Alert 3</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
