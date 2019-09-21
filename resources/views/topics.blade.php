@extends('layouts.app-fronted')

@section('content')
    <section class="site-section pt-5">
        <div class="container">
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $settings->about !!}
                        </div>
                    </div>
                    <div class="row mb-5 mt-5">
                        <div class="col-md-12 mb-5">
                            <h2>Temat: {{$topic->topic}}</h2>
                        </div>
                    <div class="col-md-12">
                        @foreach($topic->posts as $post)
                            <div class="post-entry-horzontal">
                                <a href="{{route('single', ['slug'=>$post->slug])}}">
                                    <div class="image"
                                         style="background-image: url({{asset('storage/'.$post->lead)}});"></div>
                                    <span class="text">
                          <div class="post-meta">
                            <span class="author mr-2"><img src="{{asset('storage/'.$post->user->tiny_photo)}}"
                                                           alt="Colorlib"> Colorlib</span>&bullet;
                            <time datetime="2016-04-17 12:00:00" class="mr-2">{{$post->created_at->toFormattedDateString()}}</time> &bullet;
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

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav aria-label="Page navigation" class="text-center">
                                <ul class="pagination">
                                    <li class="page-item  active"><a class="page-link" href="#">&lt;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>


                </div>

                <!-- END main-content -->

                @include('inc.sidebar')
            </div>
        </div>
    </section>

@endsection
