@extends('layouts.app-backend')

@section('content')
    {!! Form::open(['action'=>['TagsController@update', 'id'=>$tag->id], 'method'=>'put']) !!}
    <div class="form-group">
        {{Form::label('tag', 'Podaj Tag')}}
        {{Form::text('tag', $tag->tag ?? null, ['class'=>['form-control']])}}
    </div>
    {{form::submit('Zapisz', ['class'=>['btn', 'btn-success']])}}
    {{Form::close()}}


@endsection
