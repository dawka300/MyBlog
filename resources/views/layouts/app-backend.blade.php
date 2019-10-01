<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    @toastr_css
</head>
<body>
{{--@php
echo phpinfo();
@endphp--}}
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Blogprawo.pl') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj') }}</a>
                            </li>
                           {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Zarejestruj') }}</a>
                                </li>
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
                    </ul>
                </div>
            </div>
        </nav>

        <main class="m-4">
            <div class="row">
                <div class="col-3">
                    @auth
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-dark"><a href="{{route('home')}}">Strona główna</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('settings')}}">Ustawienia</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('user')}}">Użytkownik</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('posts.index')}}">Wpisy</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('user')}}">Wpisy w koszu</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('topics.index')}}">Tematy</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('tags.index')}}">Tagi</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('jokes.index')}}">Dowcipy</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('file')}}">Pliki</a></li>
                        <li class="list-group-item list-group-item-dark"><a href="{{route('image')}}">Zdjęcia</a></li>
                    </ul>
                        @endauth

                </div>
                <div class="col-9">
                    @yield('content')
                </div>
            </div>

        </main>
    </div>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    @toastr_js
    @toastr_render
    <script>

        if ($('textarea#content').length>0) {
            var CSRFToken = $('meta[name="csrf-token"]').attr('content');
            CKEDITOR.replace('content', {
                language: 'pl',
                extraPlugins:'basicstyles',
                height: 880,
                skin: 'bootstrapck',
                contentsCss: ["body {font-size: 22px;}"],
                // fontSize_sizes:'19/19px;24/24px;48/48px;',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+CSRFToken,
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+CSRFToken
                // filebrowserImageBrowseUrl: '/file-manager/ckeditor',
                // filebrowserImageBrowseUrl: '/laravel-filemanager?type=Files',
                // filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+CSRFToken,
                // filebrowserBrowseUrl: '/laravel-filemanager?type=Images',
                // filebrowserUploadUrl: '/laravel-filemanager/upload?type=Images&_token='+CSRFToken

            });
        }


    </script>
</body>
</html>
