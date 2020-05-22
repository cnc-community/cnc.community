<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('admin/css/jodit.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet">

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('admin/js/jodit.min.js') }}"></script>
    <script src="{{ asset('admin/js/app.js') }}"></script>

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <style>
    .page-title{ margin-top: 15px;margin-bottom: 15px; padding-bottom: 20px; }
    .bg-primary {
        background-color: #272b2f !important;
    }   
    .queue-count {
        background: #008aff;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        margin-left: 15px;
    }
    </style>
</head>

<body class="sb-nav-fixed">
    <div id="app">

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="/admin/dashboard">
            @guest
            C&C Community
            @else
            C&C Admin
            @endguest
            </a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            </form>
            @guest
            @else
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endguest
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            @guest
                            @else
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="/admin/dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="/">
                                <div class="sb-nav-link-icon"><i class="fas fa-link"></i></div>
                                Site
                            </a>
                            <div class="sb-sidenav-menu-heading">News</div>
                            <a class="nav-link collapsed" href="/admin/news">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Published News
                                <div class="sb-sidenav-collapse-arrow"></div>
                            </a>
                            <a class="nav-link collapsed" href="/admin/queue">
                                <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                                Pending News <span class="queue-count">{{ $queue_count }}</span>
                                <div class="sb-sidenav-collapse-arrow"></div>
                            </a>

                            <div class="sb-sidenav-menu-heading">Pages</div>
                            <a class="nav-link collapsed" href="/admin/pages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Manage Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="sb-sidenav-menu-heading">Users</div>
                            <a class="nav-link" href="/admin/users">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Manage Users
                            </a>
                            @endguest
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    @guest
                    @else
                        <div class="small">Logged in as:</div>
                        {{ Auth::user()->name }}
                    @endguest
                    </div>
                </nav>
            </div>
            
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
    </div>
</body>
</html>
