@extends('layouts.app-fronted')

@section('content')
    @include('inc.fb')
    <section class="site-section py-lg">
        <div class="container">

            <div class="row blog-entries element-animate">
                <div class="col-md-12 col-lg-8 main-content">
                    <img src="{{asset('storage/'.$postRead->lead)}}" alt="Image" class="img-fluid mb-5">
                    <div class="post-meta">
                        <span class="author mr-2"><img src="{{asset('storage/'.$postRead->user->tiny_photo)}}"
                                                       alt="Colorlib" class="mr-2">{{$postRead->user->name}}</span>&bullet;
                        <span class="mr-2">March 15, 2018 </span>
{{--                        <span class="ml-2"><span class="fa fa-comments"></span> 3</span>--}}
                    </div>
                    <h1 class="mb-4">{{$postRead->title}}</h1>
                    @foreach($postRead->tags as $tag)
                        <a class="category mb-5" href="{{route('tags', ['id'=>$tag->id])}}">{{$tag->tag}}</a>
                    @endforeach

                    <div class="post-content-body">
                        {!! $postRead->content!!}
                    </div>
                    <div class="pt-5">
                        <p>
                            <strong>Numer - {{$postRead->number}};</strong>
                            <strong style="text-align: right">{{$postRead->date_public->toFormattedDateString()}}</strong>
                        </p>
                    </div>
                    <!--Facebook-->
                    <div class="fb-like" data-href="{{url()->current()}}" data-layout="standard"
                         data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>

                    <div class="pt-5">
                        <p>Tematy: <a href="{{route('topics', ['id'=>$postRead->topic->id])}}">{{$postRead->topic->topic}}</a>
                            Tagi:
                            @foreach($postRead->tags as $tag)
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
