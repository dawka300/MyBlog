<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('inc.google-analytics')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="65RScv31l4FFSxvexxcUWukwcAi9XUXfWrb70mf2kx4" />
    <meta property="og:url"           content="{{url()->current()}}" />
    <meta property="og:type"          content="website" />
    @if(isset($postRead))
        <meta property="og:title"         content="{{$postRead->meta_desc}}" />
        <meta property="og:description"   content="{{$postRead->meta_desc}}" />
        <meta property="og:image"         content="{{asset('storage/'.$postRead->lead)}}" />
        <meta name="description" content="{{$postRead->meta_desc}}">
    @else
        <meta property="og:title"         content="{{ config('app.name', 'Blogprawo.pl') }}" />
        <meta property="og:description"   content="Inne spojrzenie na prawo..." />
        <meta property="og:image"         content="{{asset('storage/photos/1_dawka300/blog-foto/bg33.jpeg')}}" />
        <meta name="description" content="prawo, porady prawne, prawnik, blog prawny, radca prawny, aplikacja radcowska">
    @endif

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blogprawo.pl') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

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
                        @if(!empty($settings->twitter))
                        <a target="_blank" href="#"><span class="fa fa-twitter"></span></a>
                        @elseif(!empty($settings->fb))
                        <a target="_blank" href="{{url($settings->fb)}}"><span class="fa fa-facebook"></span></a>
                        @elseif(!empty($settings->yt))
{{--                        <a href="#"><span class="fa fa-instagram"></span></a>--}}
                        <a target="_blank" href="{{url($settings->yt)}}"><span class="fa fa-youtube-play"></span></a>
                        @endif
                        @guest
                            <a href="{{ route('login') }}"><span class="fa fa-sign-in"></span></a>

                            {{-- @if (Route::has('register'))
                                     <a href="{{ route('register') }}">{{ __('Register') }}</a>
                             @endif--}}
                        @else
                            <li class="nav-item dropdown" style="list-style: none; display: inline-block;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right text-white"
                                     aria-labelledby="navbarDropdown" style="background-color: #6610f2; ">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <a href="{{route("home")}}"><span class="fa fa-home"></span></a>
                        @endguest
                    </div>
                    <div class="col-3 search-top">
                        <!-- <a href="#"><span class="fa fa-search"></span></a> -->
                        <form action="{{route('result')}}" class="search-top-form" method="get">
                            <span onclick="$('form.search-top-form').submit()" style="cursor: pointer" class="icon fa fa-search"></span>
                            <input name="word" type="text" id="s0" placeholder="Wpisz szukane słowo...">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container logo-wrap">
            <div class="row pt-5">
                <div class="col-12 text-center">
                    <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button"
                       aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
                    <h1 class="site-logo"><a href="/">{{config('app.name')}}</a></h1>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md  navbar-light bg-light">
            <div class="container">


                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mx-auto">
                        {{--<li class="nav-item">
                            <a class="nav-link active" href="index.html">Home</a>
                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('jokes')}}">Krotochwile</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="dropdown05"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">Dodatki</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown05">
                                    <a class="dropdown-item" href="{{route('pesel')}}">PESEL</a>
                                    <a class="dropdown-item" href="{{route('gus')}}">Dane GUS</a>

                            </div>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{route('topics', ['id'=>1])}}" id="dropdown05"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tematy</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown05">
                                @foreach($topics as $topic)
                                    <a class="dropdown-item"
                                       href="{{route('topics', ['id'=>$topic->id])}}">{{$topic->topic}}</a>
                                @endforeach

                            </div>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('about')}}">O mnie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('contact')}}">Kontakt</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </header>
    <!-- END header -->
    @yield('content')
    <footer class="site-footer">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-4">
                    <h3>O mnie</h3>
                    <p class="mb-4">
                        <img src="{{asset('storage/'.$user->main_photo)}}" alt="Image placeholder"
                             class="img-fluid">
                    </p>

                    <p>{!! Str::limit(strip_tags($user->about), 140, '...')!!} <a href="{{route('about')}}">Czytaj
                            więcej...</a></p>
                </div>
                <div class="col-md-6 ml-auto">
                    <div class="row">
                        <div class="col-md-7">
                            <h3>Ostatnie wpisy</h3>
                            <div class="post-entry-sidebar">
                                <ul>
                                    @foreach($lastPosts as $post)
                                    <li>
                                        <a href="{{route('single', ['slug'=>$post->slug])}}">
                                            <img src="{{asset('storage/'.$post->thumbnail)}}" alt="{{$post->title}}"
                                                 class="mr-4">
                                            <div class="text">
                                                <h4>{{$post->title}}</h4>
                                                <div class="post-meta">
                                                    <span class="mr-2">{{$post->date_public->diffForHumans()}}</span>
{{--                                                    <span class="ml-2"><span class="fa fa-comments"></span> 3</span>--}}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-4">

                            <div class="mb-5">
                                <h3>Podstrony</h3>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('pesel')}}">Pesel</a></li>
                                    <li><a href="{{route('jokes')}}">Krotochwile</a></li>
                                    <li><a href="{{route('about')}}">O mnie</a></li>
                                    <li><a href="{{route('contact')}}">Kontakt</a></li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3>Media Społecznościowe</h3>
                                <ul class="list-unstyled footer-social">
                                    @if(!empty($settings->twitter))
                                        <li><a target="_blank" href="{{url($settings->twitter)}}"><span class="fa fa-twitter"></span> Twitter</a></li>
                                    @elseif(!empty($settings->fb))
                                        <li><a target="_blank" href="{{url($settings->fb)}}"><span class="fa fa-facebook"></span> Facebook</a></li>
                                    @elseif(!empty($settings->yt))
                                        <li><a target="_blank" href="{{url($settings->yt)}}"><span class="fa fa-youtube-play"></span> Youtube</a></li>
                                    @endif

{{--                                    <li><a href="#"><span class="fa fa-instagram"></span> Instagram</a></li>--}}
{{--                                    <li><a href="#"><span class="fa fa-vimeo"></span> Vimeo</a></li>                                    --}}
{{--                                    <li><a href="#"><span class="fa fa-snapchat"></span> Snapshot</a></li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="small">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script data-cfasync="false"
                                src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                        <script>document.write(new Date().getFullYear());</script>
                        All Rights Reserved | This template is made with <i class="fa fa-heart text-danger"
                                                                            aria-hidden="true"></i> by <a
                            href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- END footer -->

</div>
<script src="{{asset('js/jquery-migrate-3.0.0.js')}}"></script>
{{--<script src="{{asset('js/popper.min.js')}}"></script>--}}
{{--<script src="js/bootstrap.min.js"></script>--}}
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
{{--<script src="{{asset('js/MyJs.js')}}"></script>--}}

</body>
</html>
