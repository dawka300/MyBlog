 <section class="site-section pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="owl-carousel owl-theme home-slider">
                        @foreach($markedPosts as $post)
                            <div>
                                <a href="{{route('single', ['slug'=>$post->slug])}}" class="a-block d-flex align-items-center height-lg" style="background-image: url({{asset('storage/'.$post->lead)}}); ">
                                    <div class="text half-to-full">
                                        <span class="category mb-5">{{$post->topic->topic}}</span>
                                        <div class="post-meta">

                                            <span class="author mr-2"><img src="{{asset('storage/'.$post->user->tiny_photo)}}" alt="{{$post->title}}"> {{$post->user->name}}</span>&bullet;
                                            <span class="mr-2">{{$post->date_public->toFormattedDateString()}}</span>
{{--                                            <span class="ml-2"><span class="fa fa-comments"></span> 3</span>--}}

                                        </div>
                                        <h3>{{$post->title}}</h3>
                                        <p>{!! Str::limit(strip_tags($post->content), 70, '...')!!}</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach


                    </div>

                </div>
            </div>

        </div>


    </section>
    <!-- END section -->
