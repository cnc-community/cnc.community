@extends('layouts.app')

@section('title', 'How To Play Online - Command & Conquer Ultimate Collection')

@section('page-class', 'homepage')

@section('hero')
    <div class="feature-image-text">
        <div class="feature-image">
            <img src="/assets/images/tuc/tuc-logo.png" alt="C&C Ultimate Collection on Steam" />
        </div>
        <div class="feature-text">
            <div class="content">
                <h1 class="section-title" style="line-height:1;">
                    How To Play Online -
                    <br class="hide-for-xs" />
                    <span> The C&amp;C Ultimate Collection
                </h1>

                <p class="lead">
                    Multiplayer for these games exists thanks to the Community projects such as; <a href="#">CnCNet</a>, <a href="#">W3DHub</a> and
                    <a href="#">C&C:Online</a> supporting them.
                </p>

                <div class="buttons">
                    <a class="btn btn-secondary btn-icon" title="Buy on Steam" rel="nofollow" href="{{ \App\Constants::getTUCSteamPageUrl() }}">
                        Buy on Steam <i class="icon-steam"></i>
                    </a>
                    <a class="btn btn-secondary btn-icon" title="Buy on EA Origin" rel="nofollow" href="{{ \App\Constants::getTUCEAPageUrl() }}">
                        Buy on EA App <i class="icon-ea"></i>
                    </a>
                </div>
            </div>
        </div>
    @endsection

    @section('content')
        <section id="games" class="how-to-guides">
            <div class="main-content">
                <h2 class="section-title">How To Play Online</h2>

                <p class="section-description lead" style="color:white;margin-bottom:35px;">
                    To Play Online - Click the guide for each game below.
                </p>

                <div class="community-support-buttons text-left" style="width:650px;max-width:100%;margin:auto;">

                    <div class="online-guide-box">
                        <h2 style="margin-bottom:0;" class="h4">
                            Tiberian Dawn, Red Alert, Tiberian Sun and <br class="hide-for-xs" />Red Alert 2 & Yuri's Revenge Online
                        </h2>
                        <p>
                            CnCNet supports online multiplayer for Tiberian Dawn, Red Alert, Tiberian Sun and <a href="https://cncnet.org/red-alert-2">Red Alert 2 &
                                Yuri's Revenge</a>.
                            Online and works with Steam and EA App digital downloads.
                        </p>
                        <p class="text-center">
                            <a href="https://cncnet.org" class="btn btn-primary" style="max-width:max-content;margin:auto;">Go to CnCNet</a>
                        </p>
                    </div>

                    <div class="online-guide-box">
                        <h2 style="margin-bottom:0;" class="h4">
                            Renegade Online
                        </h2>
                        <p>
                            W3D Hub supports Renegade online multiplayer and a range of community made mods. Online works with Steam and EA App digital downloads.
                        </p>
                        <p class="text-center">
                            <a href="https://w3dhub.com/games/command-conquer-renegade/" class="btn btn-primary" style="max-width:max-content;margin:auto;">Go to
                                W3D Hub</a>
                        </p>
                    </div>

                    <div class="online-guide-box">
                        <h2 style="margin-bottom:0;" class="h4">
                            Generals, Tiberium Wars, Red Alert 3
                        </h2>
                        <p>
                            C&C:Online supports Generals, Tiberium Wars, Red Alert 3 and works with Steam and EA App digital downloads.
                        </p>
                        <p class="text-center">
                            <a href="https://w3dhub.com/games/command-conquer-renegade/" class="btn btn-primary" rel="nofollow"
                                style="max-width:max-content;margin:auto;">Go to C&C:Online</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="guides">
                <?php new App\Http\CustomView\Components\GameSlider($__env, true); ?>
            </div>
        </section>
    @endsection
