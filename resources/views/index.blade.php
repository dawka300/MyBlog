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
                                        <span class="mr-2">March 15, 2018 </span> &bullet;
                                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                                    </div>
                                    <h2>{{$post->title}}</h2>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-5">
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
