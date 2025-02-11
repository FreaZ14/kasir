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

    <!-- Scripts -->
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
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
                        <a href="{{ route('home') }}" wire:navigate class="btn {{ request()->routeIs('home') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Beranda  
                        </a>
                        <a href="{{ route('user') }}" wire:navigate class="btn {{ request()->routeIs('user') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Pengguna
                        </a>
                        <a href="{{ route('barang') }}" wire:navigate class="btn {{ request()->routeIs('barang') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Barang
                        </a>
                        <a href="{{ route('pembelian') }}" wire:navigate class="btn {{ request()->routeIs('pembelian') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Pembelian
                        </a>
                        <a href="{{ route('laporan') }}" wire:navigate class="btn {{ request()->routeIs('laporan') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Laporan
                        </a>
                        <a href="{{ route('penjualan') }}" wire:navigate class="btn {{ request()->routeIs('penjualan') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Penjualan
                        </a>
                        <a href="{{ route('detail-penjualan') }}" wire:navigate class="btn {{ request()->routeIs('detail-penjualan') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Detail Penjualan
                        </a>
                        <a href="{{ route('detail-pembelian') }}" wire:navigate class="btn {{ request()->routeIs('detail-pembelian') ? 'btn-primary' : 'btn-outline-primary' }}">
                          Detail Pembelian
                        </a>    
                    </div>
                </div>
            </div>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
