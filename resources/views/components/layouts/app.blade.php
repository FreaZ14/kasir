<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" style="border-bottom: 2px solid #3498db;">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" style="{{ request()->routeIs('home') ? 'background-color: #3498db; color: white;' : 'background-color: #e6f2ff; color: #3498db;' }}" href="{{ route('home') }}">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user') ? 'active' : '' }}" style="{{ request()->routeIs('user') ? 'background-color: #2ecc71; color: white;' : 'background-color: #e6f8f7; color: #2ecc71;' }}" href="{{ route('user') }}">Pengguna</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('barang') ? 'active' : '' }}" style="{{ request()->routeIs('barang') ? 'background-color: #e74c3c; color: white;' : 'background-color: #ffe6e6; color: #e74c3c;' }}" href="{{ route('barang') }}">Barang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pembelian') ? 'active' : '' }}" style="{{ request()->routeIs('pembelian') ? 'background-color: #2ecc71; color: white;' : 'background-color: #e6f2ff; color: #2ecc71;' }}" href="{{ route('pembelian') }}">Pembelian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('penjualan') ? 'active' : '' }}" style="{{ request()->routeIs('penjualan') ? 'background-color:  #3498db; color: white;' : 'background-color: #e6f8f7; color: #3498db;' }}" href="{{ route('penjualan') }}">Penjualan</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
