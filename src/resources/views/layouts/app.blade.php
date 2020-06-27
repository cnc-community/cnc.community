<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - C&C Community</title>

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title') - Command &amp; Conquer">
    <meta property="og:site_name" content="C&C Community">

    @if(View::hasSection('meta'))
    @yield('meta')
    @else
    <meta property="og:image" content="https://cnc.community/assets/images/meta.png">
    @endif

    @if(View::hasSection('description'))
    <meta property="og:description" content="@yield('description')">
    <meta name="description" content="@yield('description')">
    @else
    <meta name="description" content="Find how to play guides for Command & Conquer games. Find C&C news and C&C mods from the C&C community, including C&C Remastered Leaderboards">
    @endif
    <meta name="author" content="C&C Community">
    <meta name="keywords" content="cnc tdra map editor, cnc tdra, cnc tdra ladder, C&amp;C Leaderboard, C&amp;C Remastered Leaderboard, tiberian dawn remastered ladder, red alert remastered ladder, C&amp;C, Command &amp; Conquer, C&amp;C95, C&mp;C1, RA, RA95, Tiberian, Sun, Tiberium, Red Alert, Red, Alert, Red Alert 3, Renegade, C&C Remastered, Command & Conquer Remasters, Red Alert 1 Remastered, 
        Tiberian Dawn Remastered, Red Alert 2,Generals,C&amp;C3: Tiberium Wars, C&amp;C Mods, C&amp;C Mod Workshop, C&amp;C Steam Workshop" 
    />

    <meta name="google-site-verification" content="xrCaa-F6MyCOiXD6KvugZJtt80qKj8uPbmoU74lxAPE" />
    <link rel="stylesheet" href="/assets/css/app.css?v=2.6" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/assets/images/favicon/safari-pinned-tab.svg" color="#000000">
    <link rel="shortcut icon" href="/assets/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/assets/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#000000">
</head>
<body>

<main>
    <div class="page page-@yield('page-class')">
        <header id="nav" class="site-header nav-closed">
            <div class="main-content">
                <div class="logo-burger-container">
                    <div class="logo">
                        <a href="/" title="C&C Community">
                            <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
                        </a>
                    </div>

                    <button id="mobileMenuToggle" class="navburger navburger--elastic " type="button">
                        <span class="navburger-box">
                            <span class="navburger-inner"></span>
                        </span>
                    </button>
                </div>

                <nav class="mobile-navigation">
                    @include("layouts.navigation.mobile-menu")
                </nav>

                <nav class="main-navigation">
                    @include("layouts.navigation.main-menu")
                </nav>
            </div>
        </header>

        <main role="main">
            @if(View::hasSection('hero'))
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
                    <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
                    <small>
                        Copyright C&amp;C Community &copy; <?php echo date("Y"); ?>
                    </small>
                </div>

                <div class="copyright-notice text-uppercase">
                    <div class="copyright-links text-uppercase">
                        <a href="/terms-and-conditions" title="Contact">Terms</a> 
                        <a href="/privacy-policy" title="Privacy">Privacy Policy</a> 
                        <a href="/contact" title="Contact">Contact</a> 
                    </div>
                    <p class="notice">
                        C&amp;C Community has no affiliation with Electronic Arts or PetroGlyph Games
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @yield('scripts')
    <script defer src="/assets/js/SiteCountNav.js?v=2.6"></script>
    <script defer src="/assets/js/NavBarJs.js?v=2.6"></script>
</body>
</html>