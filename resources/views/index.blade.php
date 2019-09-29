@extends('layouts.app-fronted')

@section('content')
    @include('inc.carousel')
    <section class="site-section py-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">Ostatnie wpisy</h2>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row">

                            @foreach($posts as $post)
                            <div class="col-md-6">
                            <a href="{{route('single', ['slug'=>$post->slug])}}" class="blog-entry element-animate" data-animate-effect="fadeIn">
                                <img style="height: 240px; width: 100%;" src="{{asset('storage/'.$post->lead)}}" alt="{{$post->title}}">
                                <div class="blog-content-body">
                                    <div class="post-meta">
                                        <span class="author mr-2"><img src="{{asset('storage/'.$post->user->tiny_photo)}}" alt="Colorlib"> {{$post->user->name}}</span>&bullet;
                                        <span class="mr-2">{{$post->date_public->toFormattedDateString()}}</span>
{{--                                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>--}}
                                    </div>
                                    <h2>{{$post->title}}</h2>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    {{$posts->links()}}

                </div>

                <!-- END main-content -->
                @include('inc.sidebar')



            </div>
        </div>
    </section>


@endsection
