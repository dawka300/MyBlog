<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blogprawo.pl') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('fonts/ionicons/css/ionicons.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/flaticon/font/flaticon.css')}}">

</head>
<body>
<div class="wrap">

    <header role="banner">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-9 social">
                        <a href="#"><span class="fa fa-twitter"></span></a>
                        <a href="#"><span class="fa fa-facebook"></span></a>
                        <a href="#"><span class="fa fa-instagram"></span></a>
                        <a href="#"><span class="fa fa-youtube-play"></span></a>
                        @guest
                            <a href="{{ route('login') }}"><span class="fa fa-sign-in"></span></a>

                           {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif--}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                        @endguest
                    </div>
                    <div class="col-3 search-top">
                        <!-- <a href="#"><span class="fa fa-search"></span></a> -->
                        <form action="#" class="search-top-form">
                            <span class="icon fa fa-search"></span>
                            <input type="text" id="s" placeholder="Wpisz szukaną frazę...">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container logo-wrap">
            <div class="row pt-5">
                <div class="col-12 text-center">
                    <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
                    <h1 class="site-logo"><a href="/">{{ config('app.name', 'Blogprawo.pl') }}</a></h1>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md  navbar-light bg-light">
            <div class="container">


                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="category.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tematy</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown04">
                                <a class="dropdown-item" href="category.html">Asia</a>
                                <a class="dropdown-item" href="category.html">Europe</a>
                                <a class="dropdown-item" href="category.html">Dubai</a>
                                <a class="dropdown-item" href="category.html">Africa</a>
                                <a class="dropdown-item" href="category.html">South America</a>
                            </div>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">O mnie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Wsparcie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Dowcipy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Program PESEL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Kontakt</a>
                        </li>

                       {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="category.html" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown05">
                                <a class="dropdown-item" href="category.html">Lifestyle</a>
                                <a class="dropdown-item" href="category.html">Food</a>
                                <a class="dropdown-item" href="category.html">Adventure</a>
                                <a class="dropdown-item" href="category.html">Travel</a>
                                <a class="dropdown-item" href="category.html">Business</a>
                            </div>

                        </li>--}}

                    </ul>

                </div>
            </div>
        </nav>
    </header>
    <!-- END header -->
</div>

</body>
</html>
