@extends('layouts.app-fronted')

@section('content')
    <section class="site-section py-lg">
        <div class="container">

            <div class="row blog-entries element-animate">
                <div class="col-md-12 col-lg-8 main-content">
                    <img src="{{asset('storage/'.$post->lead)}}" alt="Image" class="img-fluid mb-5">
                    <div class="post-meta">
                        <span class="author mr-2"><img src="{{asset('storage/'.$post->user->tiny_photo)}}"
                                                       alt="Colorlib" class="mr-2">{{$post->user->name}}</span>&bullet;
                        <span class="mr-2">March 15, 2018 </span> &bullet;
                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                    </div>
                    <h1 class="mb-4">{{$post->title}}</h1>
                    @foreach($post->tags as $tag)
                        <a class="category mb-5" href="#">{{$tag->tag}}</a>
                    @endforeach

                    <div class="post-content-body">
                        {!! $post->content!!}
                    </div>
                    <div class="pt-5">
                        <p>
                            <strong>Mętów, {{$post->date_public->toFormattedDateString()}}</strong> <br>
                            <strong>Numer - {{$post->number}}</strong>
                        </p>
                    </div>


                    <div class="pt-5">
                        <p>Tematy: <a href="{{route('topics', ['id'=>$post->topic->id])}}">{{$post->topic->topic}}</a>
                            Tagi:
                            @foreach($post->tags as $tag)
                                @if(!$loop->last)
                                <a href="{{route('tags', ['id'=>$tag->id])}}">#{{$tag->tag}}</a>,
                                @else
                                    <a href="{{route('tags', ['id'=>$tag->id])}}">#{{$tag->tag}}</a>
                                @endif
                            @endforeach
                        </p>
                    </div>


                    <div class="pt-5">
                        @include('inc.disqus')
                    </div>

                </div>

                <!-- END main-content -->


                @include('inc.sidebar')
            </div>
        </div>
    </section>

@endsection
