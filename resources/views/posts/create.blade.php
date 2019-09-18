@extends('layouts.app-backend')

@section('content')
    @include('inc.error')
    {!! Form::open(['action'=>'PostsController@store', 'method'=>'post', 'class'=>'text-white']) !!}
    <div class="form-group">
        <h3>Wpisz temat artykułu</h3>
        {{Form::text('title', null, ['class'=>['form-control']])}}
    </div>
    <div class="form-group">
        <h3>Wybierz kategorię</h3>
        {{Form::select('category', $topics, null, ['class'=>['form-control']])}}
    </div>
    @foreach($tags as $tag)
        <div class="form-check">
            {{Form::checkbox('tags[]', $tag->id, null, ['class'=>'form-check-input', 'id'=>'tags'.$tag->id] )}}
            {{Form::label('tags'.$tag->id, $tag->tag)}}
        </div>
    @endforeach
    <div class="form-group">
        <h3>Treść posta</h3>
        {{Form::textarea('content', null, ['class'=>['form-control'], 'id'=>'content'])}}
    </div>
    {{form::submit('Zapisz', ['class'=>['btn', 'btn-success']])}}
    {{Form::close()}}


@endsection
