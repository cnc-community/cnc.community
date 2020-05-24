<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - C&C Community</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Oswald:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css" />
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
                </div>

                <div class="copyright-notice">
                    <small>Copyright C&C Community &copy; <?php echo date("Y"); ?></small>

                    <div class="copyright-links">
                        <a href="#">Privacy Policy</a> 
                        <a href="#">Terms</a> 
                    </div>
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