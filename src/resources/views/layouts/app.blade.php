<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - C&C Community</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Oswald:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css" />

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
                <div class="logo">
                    <a href="/" title="C&C Community">
                        <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
                    </a>
                </div>

                <nav class="mobile-navigation">
                    @include("layouts.navigation.mobile-menu")
                </nav>

                <nav class="main-navigation">
                    @include("layouts.navigation.main-menu")
                </nav>

                <button id="mobileMenuToggle" class="navburger navburger--elastic " type="button">
                    <span class="navburger-box">
                        <span class="navburger-inner"></span>
                    </span>
                </button>
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
                        Copyright C&C Community &copy; <?php echo date("Y"); ?>
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
    <script defer src="/assets/js/SiteCountNav.js"></script>
    <script defer src="/assets/js/NavBarJs.js"></script>
    <script defer>
        var navToggleBtn = document.getElementById("mobileMenuToggle");
        var navToggle = document.getElementById("nav");

        navToggleBtn.addEventListener("click", function()
        {
            navToggleBtn.classList.toggle("is-active");
            navToggle.classList.toggle("nav-open");
        }, false);
    </script>
</body>
</html>