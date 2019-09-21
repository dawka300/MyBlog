@extends('layouts.app-backend')

@section('content')
    @include('inc.error')
    {!! Form::open(['action'=>['PostsController@update', 'id'=>$post->id], 'method'=>'put', 'class'=>'text-white']) !!}
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <h3>Wpisz temat artykułu</h3>
                {{Form::text('title', $post->title ?? null, ['class'=>['form-control'], 'required'=>true])}}
            </div>
        </div>
    </div>
   {{-- <div class="row">
        <div class="col-8">
            <div class="form-group">
                <h3>Slug</h3>
                {{Form::text('slug', $post->slug ?? null, ['class'=>['form-control'], 'required'=>true])}}
            </div>
        </div>
    </div>--}}
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Wybierz kategorię</h3>
                {{Form::select('category', $topics, $post->topic_id ?? null, ['class'=>['form-control']])}}
            </div>
        </div>
    </div>
    <h3>Wybierz tagi:</h3>
    <div class="row">
        <div class="col-8 ">
            @foreach($tags as $tag)
                <div class="form-check form-check-inline">
                    <input type="checkbox" value="{{$tag->id}}" name="tags[]" id="tag{{$tag->id}}" class="form-check-input big-checkbox"
                           @foreach($post->tags as $t)
                           @if($tag->id===$t->id)
                           checked
                        @endif

                        @endforeach

                    >
                    <label style="color:#333;font-style:italic;" class="form-check-inline big-label-checkbox" for="tag{{$tag->id}}">{{$tag->tag}}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <h3>Treść posta</h3>
        {{Form::textarea('content', $post->content, ['class'=>['form-control'], 'id'=>'content'])}}
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <h3>Wpisz dane meta dla przeglądarek</h3>
                {{Form::text('meta_desc', $post->meta_desc ?? null, ['class'=>['form-control'], 'required'=>true])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Wprowadź datę publikacji</h3>
                {{Form::date('date_public', $post->date_public ?? null, ['class'=>['form-control'], 'required'=>true ])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Numer</h3>
                {{Form::number('number', $post->number ?? null, ['class'=>['form-control'], 'required'=>true ])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h3 class="text-white">Wybierz zdjęcie - lead</h3>
            <div class="input-group">

           <span class="input-group-btn">
             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
               <i class="fa fa-picture-o"></i> Wybierz
             </a>
           </span>
                <input id="thumbnail" class="form-control" type="text"
                       name="lead" value="{{$post->lead ?? null}}">
            </div>
            <img id="holder"
                 style="margin-top:15px;max-height:250px;" {{!empty($post->lead) ? 'src='.url('storage/'.$post->lead) : null}}>
        </div>
        <div class="col-6">
            {{-- <h3 class="text-white">Wybierz zdjęcie - Lead FB</h3>
             <div class="input-group">

            <span class="input-group-btn">
              <a id="lfm2" data-input="thumbnail2" data-preview="holder" class="btn btn-primary text-white">
                <i class="fa fa-picture-o"></i> Wybierz
              </a>
            </span>
                 <input id="thumbnail2" class="form-control" type="text"
                        name="lead_fb">
             </div>
             <img id="holder2"
                  style="margin-top:15px;max-height:250px;">--}}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
        </div>
    </div>



    {{Form::close()}}


@endsection
