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
        <header class="site-header">
            <div class="main-content">
                <div class="logo">
                    <a href="/" title="C&C Community">
                        <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
                    </a>
                </div>
                <nav>
                    <div class="navbar-items">
                        <div class="nav-item nav-item-dropdown">
                            <a href="/#games" title="Games" class="nav-link">Games <i class="icon icon-dropdown"></i></a>

                            <div class="nav-dropdown-contents">
                                <div class="dropdown-container">
                                    <div class="category">
                                        <div class="title">C&amp;C Games</div>
                                        <a href="/tiberian-dawn" title="Tiberian Dawn">Tiberian Dawn</a>
                                        <a href="/red-alert" title="Red Alert">Red Alert</a>
                                        <a href="/tiberian-sun" title="Tiberian Sun">Tiberian Sun</a>
                                        <a href="/red-alert-2" title="Red Alert 2">Red Alert 2</a>
                                        <a href="/renegade" title="Renegade">Renegade</a>
                                        <a href="/generals" title="Generals">Generals</a>
                                        <a href="/red-alert-3" title="Renegade">Red Alert 3</a>
                                        <a href="/command-and-conquer-3" title="C&C 3">C&amp;C 3</a>
                                        <a href="/command-and-conquer-4" title="C&C 4">C&amp;C 4</a>
                                    </div>
                                    <div class="category">
                                        <div class="title">2020 Games</div>
                                        <a href="/remasters" title="Remasters Collection">C&amp;C Remaster Collection </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="nav-item">
                            <a href="/creators" id="navCreators" title="Creators" class="nav-link">Creators <span class="online">0</span></a>
                        </div>
                        <div class="nav-item">
                            <a href="/remasters" title="Remasters" class="nav-link">Remasters</a>
                        </div>
                        <div class="nav-item">
                            <a href="/funny" title="Funny/Cool" class="nav-link">Funny/Cool</a>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="https://www.facebook.com/groups/commandandconquer" title="C&C Facebook Group"><i class="icon-facebook"></i></a>
                        <a href="#" title="C&C Twitter"><i class="icon-twitter"></i></a>
                        <a href="https://discord.gg/zktcZQY" title="C&C Discord"><i class="icon-discord"></i></a>
                        <a href="https://store.steampowered.com/app/1213210" title="C&C Steam"><i class="icon-steam"></i></a>
                        <a href="https://www.reddit.com/r/commandandconquer" title="C&C Reddit" rel="nofollow"><i class="icon-reddit"></i></a>
                    </div>
                </nav>
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
    <script>
        let navitems = document.querySelectorAll(".nav-item");
        console.log(navitems);
        for(let i = 0; i < navitems.length; i++)
        {
            let navItem = navitems[i];
            let navItemChildren = navItem.querySelector(".nav-dropdown-contents");

            navItem.addEventListener("mouseenter", function()
            {   
                if (navItem.classList.contains("open"))
                {
                    console.log(navItem.classList.contains("open"));
                    return;
                }
                navItem.classList.add("open");
                navItem.classList.remove("close");
                navItemChildren.style.display = "flex";
            }, false);  

            if(navItemChildren == null) continue;
            navItemChildren.addEventListener("mouseenter", function()
            {
                navItem.addEventListener("mouseleave", function()
                {
                    navItem.classList.remove("open");
                    navItem.classList.add("close");
                }, false);
            }, false);
        }
    </script>
</body>
</html>