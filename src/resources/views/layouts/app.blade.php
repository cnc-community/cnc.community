<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - C&C Community</title>
    <link rel="stylesheet" href="css/app.css" />
</head>
<body>

<main>
    <div class="page page-@yield('page-class')">
        <header class="site-header">
            <div class="main-content">
                <div class="logo">
                    <a href="/" title="C&C Community">
                        <img src="/images/logo.svg" alt="C&C Community Logo" />
                    </a>
                </div>
                <nav>
                    <div>
                        <a href="#">Games</a>
                        <a href="#">Communities</a>
                        <a href="#">Creators</a>
                        <a href="#">Modding</a>
                    </div>
                </nav>
            </div>
        </header>

        <main role="main">
            <section class="hero">
                <div class="hero-content">
                    @yield('hero')
                </div>
            </section>

            @yield('content')
        </main>
        <footer role="contentinfo">
        </footer>
    </div>
</main>
    
</body>
</html>