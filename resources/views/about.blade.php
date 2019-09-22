@extends('layouts.app-fronted')

@section('content')
    <section class="site-section pt-5">
        <div class="container">

            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">

                    <div class="row">
                        <div class="col-md-12">
                            {!! $user->about !!}
                        </div>
                    </div>

                    <div class="row mb-5 mt-5">
                        <div class="col-md-12 mb-5">
                            <h2>Moje ostatnie wpisy</h2>
                        </div>
                        <div class="col-md-12">
                            @foreach($posts as $post)

                        <div class="post-entry-horzontal">
                            <a href="blog-single.html">
                                <div class="image" style="background-image: url({{asset('storage/'.$post->lead)}});"></div>
                                <span class="text">
                                  <div class="post-meta">
                                    <span class="author mr-2"><img src="{{asset('storage/'.$user->tiny_photo)}}" alt="{{$user->name}}"> {{$user->name}}</span>&bullet;
                                    <span class="mr-2">{{$post->date_public->toformattedDateString()}}</span> &bullet;
                                    <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                                  </div>
                                <h2>{{$post->title}}</h2>
                                </span>
                                </a>
                            </div>
                            <!-- END post -->
                                @endforeach

                        </div>
                    </div>
                    {{$posts->links()}}

                </div>

                <!-- END main-content -->

                @include('inc.sidebar')
            </div>
        </div>
    </section>

@endsection
