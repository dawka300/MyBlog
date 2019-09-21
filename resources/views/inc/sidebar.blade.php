<div class="col-md-12 col-lg-4 sidebar">
    <div class="sidebar-box search-form-wrap">
        <form action="#" class="search-form">
            <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" class="form-control" id="s" placeholder="Wpisz słowo i naciśnij enter">
            </div>
        </form>
    </div>
    <!-- END sidebar-box -->
   {{-- <div class="sidebar-box">
        <div class="bio text-center">
            <img src="images/person_1.jpg" alt="Image Placeholder" class="img-fluid">
            <div class="bio-body">
                <h2>David Craig</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.</p>
                <p><a href="#" class="btn btn-primary btn-sm rounded">Read my bio</a></p>
                <p class="social">
                    <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
                    <a href="#" class="p-2"><span class="fa fa-youtube-play"></span></a>
                </p>
            </div>
        </div>
    </div>--}}
    <!-- END sidebar-box -->
    <div class="sidebar-box">
        <h3 class="heading">Wyróżnione wpisy</h3>
        <div class="post-entry-sidebar">
            <ul>
                @foreach($markedPosts as $post)
                <li>
                    <a href="{{route('single', ['slug'=>$post->slug])}}">
                        <img src="{{asset('storage/'.$post->lead)}}" alt="{{$post->title}}" class="mr-4">
                        <div class="text">
                            <h4>{{$post->title}}</h4>
                            <div class="post-meta">
                                <span class="mr-2">March 15, 2018 </span>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">Tematy</h3>
        <ul class="categories">
            @foreach($topics as $topic)
            <li><a href="{{route('topics', ['id'=>$topic->id])}}">{{$topic->topic}} <span>{{$topic->posts->count()}}</span></a></li>
            @endforeach
        </ul>
    </div>
    <!-- END sidebar-box -->

    <div class="sidebar-box">
        <h3 class="heading">Tags</h3>
        <ul class="tags">
            @foreach($tags as $tag)
            <li><a href="#">{{$tag->tag}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<!-- END sidebar -->
