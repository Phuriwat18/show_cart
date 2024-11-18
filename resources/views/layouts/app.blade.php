<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ร้านค้าของภู</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* subtle shadow */
            border-bottom: 2px solid #fff;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-link {
            font-size: 1.1rem;
            padding: 10px 15px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background-color: #007bff;
        }

        .dropdown-item {
            color: white;
        }

        .dropdown-item:hover {
            background-color: #0056b3;
        }

        /* Active state for nav-links */
        .nav-item.active .nav-link {
            background-color: #004085;
            color: white;
        }

        /* Body and content styling */
        body {
            font-family: 'Nunito', sans-serif;
        }

        main {
            padding-top: 20px;
        }

        /* ปรับแต่งตำแหน่งของป้ายจำนวนสินค้า */
        .nav-link {
            position: relative;
        }

        /* ปรับให้ป้ายจำนวนสินค้าอยู่ด้านล่างของไอคอน */
        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            background-color: #dc3545;
            /* สีแดงสำหรับ badge */
        }

        /* เปลี่ยนสีป้ายเมื่อมีจำนวนสินค้า */
        .nav-link:hover .badge {
            background-color: #e63946;
        }

        /* ปรับตำแหน่งของป้ายจำนวนสินค้า */
        .badge-pill {
            border-radius: 50%;
        }

        .position-relative {
            position: relative;
        }

        /* ปรับตำแหน่งของป้ายให้อยู่ด้านล่าง */
        .position-absolute {
            position: absolute;
        }

        .bottom-0 {
            bottom: 0;
        }

        .start-100 {
            left: 100%;
        }

        .translate-middle {
            transform: translate(-50%, 50%);
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    ร้านค้าของภู
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('/home') }}">สินค้า</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('orders.index') }}">
                                <i class="fas fa-shopping-cart"></i> ตะกร้า
                                @if ($totalItemsInCart > 0)
                                    <span class="badge badge-pill badge-danger">{{ $totalItemsInCart }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('products.index') }}">ADMIN</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
