<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - C&C Community</title>

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:site_name" content="C&C Community">

    @if (View::hasSection('meta'))
        @yield('meta')
    @else
        <meta property="og:image" content="{{ Vite::asset('resources/assets/images/meta.png') }}">
    @endif

    @if (View::hasSection('description'))
        <meta property="og:description" content="@yield('description')">
        <meta name="description" content="@yield('description')">
    @else
        <meta name="description"
            content="Find how to play guides for Command & Conquer games. Find C&C news and C&C mods from the C&C community, including C&C Remastered Leaderboards">
    @endif

    <meta name="author" content="C&C Community">
    <meta name="keywords"
        content="cnc tdra map editor, cnc tdra, cnc tdra ladder, C&amp;C Leaderboard, C&amp;C Remastered Leaderboard, tiberian dawn remastered ladder, red alert remastered ladder, C&amp;C, Command &amp; Conquer, C&amp;C95, C&mp;C1, RA, RA95, Tiberian, Sun, Tiberium, Red Alert, Red, Alert, Red Alert 3, Renegade, C&C Remastered, Command & Conquer Remasters, Red Alert 1 Remastered, 
        Tiberian Dawn Remastered, Red Alert 2,Generals,C&amp;C3: Tiberium Wars, C&amp;C Mods, C&amp;C Mod Workshop, C&amp;C Steam Workshop" />
    <meta property="fb:pages" content="100994338349629" />

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&display=swap" rel="stylesheet">
    <meta name="google-site-verification" content="xrCaa-F6MyCOiXD6KvugZJtt80qKj8uPbmoU74lxAPE" />

    @yield('head')

    @vite(['resources/assets/stylesheets/app.scss', 'resources/assets/typescript/App.ts'])

    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ Vite::asset('resources/assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ Vite::asset('resources/assets/images/favicon/safari-pinned-tab.svg') }}" color="#000000">
    <link rel="shortcut icon" href="{{ Vite::asset('resources/assets/images/favicon/favicon.ico') }}">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#000000">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4LSB0CYJZN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-4LSB0CYJZN');
    </script>
</head>

<body>
    <main>
        <div class="page page-@yield('page-class')">
            <header id="nav" class="site-header nav-closed">
                <div class="main-content">
                    <div class="logo-burger-container">
                        <div class="logo">
                            <a href="/" title="C&C Community">
                                <img src="{{ Vite::asset('resources/assets/images/logo.svg') }}" alt="C&C Community Logo" />
                            </a>
                        </div>

                        <button id="mobileMenuToggle" class="navburger navburger--elastic" type="button" title="Mobile Menu">
                            <span class="navburger-box">
                                <span class="navburger-inner"></span>
                            </span>
                        </button>
                    </div>

                    <nav class="mobile-navigation">
                        @include('layouts.navigation.mobile-menu')
                    </nav>

                    <nav class="main-navigation">
                        @include('layouts.navigation.main-menu')
                    </nav>
                </div>
            </header>

            <main role="main">
                @if (View::hasSection('hero'))
                    <section class="hero @yield('hero-class')">
                        @yield('hero-video')
                        <div class="hero-content">
                            @yield('hero')
                        </div>
                    </section>
                @endif

                @yield('content')
            </main>

            <footer role="contentinfo">
                <div class="main-content center">
                    <div class="logo">
                        <img src="{{ Vite::asset('resources/assets/images/logo.svg') }}" alt="C&C Community Logo" />
                        <small>
                            Copyright C&amp;C Community &copy; <?php echo date('Y'); ?>
                        </small>
                    </div>

                    <div class="social-links" style="margin-top: 20px; margin-bottom: 20px;">
                        <a href="https://www.facebook.com/groups/commandandconquer" title="C&C Facebook Group" rel="nofollow noreferrer" target="_blank">
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="https://twitter.com/cnccomofficial" title="C&C Community Twitter" rel="nofollow noreferrer" target="_blank">
                            <i class="icon-twitter"></i>
                        </a>
                        <a href="https://discord.gg/zktcZQY" title="C&C Discord" rel="nofollow noreferrer" target="_blank">
                            <i class="icon-discord"></i>
                        </a>
                        <a href="https://store.steampowered.com/franchise/CandC" title="C&C Steam" rel="nofollow noreferrer" target="_blank">
                            <i class="icon-steam"></i>
                        </a>
                        <a href="https://www.reddit.com/r/commandandconquer" title="C&C Reddit" rel="nofollow noreferrer" target="_blank">
                            <i class="icon-reddit"></i>
                        </a>
                    </div>

                    <div class="copyright-notice text-uppercase">
                        <p>
                        <div class="mt-3 mb-3">
                            <a href="https://grant-bartlett.com" target="_blank" title="Website Designed &amp; Developed by Grant Bartlett"
                                style="color:#fff;">
                                Website Designed &amp; Developed <br>by Grant Bartlett
                            </a>
                        </div>
                        </p>
                        <div class="copyright-links text-uppercase">
                            <a href="/terms-and-conditions" title="Contact">Terms</a>
                            <a href="/privacy-policy" title="Privacy">Privacy Policy</a>
                            <a href="/contact" title="Contact">Contact</a>
                            <a href="/legal" title="Legal">Legal</a>
                            <a href="/donate" title="Donate">Donate</a>
                        </div>
                        <p class="notice">
                            C&amp;C Community has no affiliation with Electronic Arts or PetroGlyph Games
                        </p>
                    </div>
                </div>
            </footer>
        </div>
        <div class="site-notification js-site-notification hidden">
            <div class="main-content">
                <div class="site-notification-title">
                    <p>
                        The C&amp;C Community website runs on donations. <a href="/donate" title="Read more">Find out more</a>
                    </p>
                </div>
                <div class="site-notification-donate">
                    <a href="/donate" class="btn btn-outline" title="Donate">Donate</a>
                </div>
                <div class="site-notification-close">
                    <button class="js-site-notification-close btn btn-transparent" title="Close notification">
                        <i class="icon icon-close"></i>
                    </button>
                </div>
            </div>
        </div>

        @yield('scripts')
        <script src="/static/vendor/masonry.js"></script>
        <script>
            var baseWidth = 250;
            if (window.innerWidth >= 768) {
                baseWidth = 450;
            }

            var selectors = document.querySelectorAll(".masonry-wrap");
            for (var i = 0; i < selectors.length; i++) {
                var masonry = new MiniMasonry({
                    container: selectors[i],
                    baseWidth: baseWidth,
                    surroundingGutter: false,
                    gutter: 35
                });
                window.addEventListener("load", () => masonry.layout());
                window.addEventListener("resize", () => masonry.layout());
            }
        </script>
    </main>
</body>

</html>
