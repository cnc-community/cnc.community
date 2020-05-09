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

        <div class="admin-nav">
            @guest
            <div class="logged-in">
                <h5>Temp admin bar</h5>
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </div>
            @else
            <div class="logged-in">
                <p>
                    Hi {{ Auth::user()->name }},

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout?') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </p>
            </div>

            <a href="{{ route('admin.pages.listing') }}">{{ __('Manage Pages') }}</a>
            <a href="{{ route('admin.users.listing') }}">{{ __('Manage Users') }}</a>
            <a href="{{ route('admin.news.listing') }}">{{ __('Manage News') }}</a>
            <a href="{{ route('admin.queue.listing') }}">{{ __('News Feed') }}</a>
            <a href="{{ route('admin.feed') }}">{{ __('Run Task') }}</a>
            @endguest
        </div>

        <header class="site-header">
            <div class="main-content">
                <div class="logo">
                    <a href="/" title="C&C Community">
                        <img src="/assets/images/logo.svg" alt="C&C Community Logo" />
                    </a>
                </div>
                <nav>
                    <div>
                        <a href="/#games">Games</a>
                        {{-- <a href="#">Communities</a> --}}
                        <a href="#">Creators</a>
                        <a href="#">Remasters</a>
                        <a href="/funny">Funny/Cool</a>
                        {{-- <a href="#">Modding</a> --}}
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="icon-discord"></i></a>
                        <a href="#"><i class="icon-facebook"></i></a>
                        <a href="#"><i class="icon-twitter"></i></a>
                        <a href="#"><i class="icon-steam"></i></a>
                        <a href="#"><i class="icon-reddit"></i></a>
                    </div>
                </nav>
            </div>
        </header>

        <main role="main">
         @if(View::hasSection('hero'))
            <section class="hero">
                <div class="hero-content">
                    @yield('hero')
                </div>
            </section>
            @endif

            @yield('content')
        </main>
        
        <footer role="contentinfo">
        </footer>
    </div>

    @yield('scripts')
</body>
</html>