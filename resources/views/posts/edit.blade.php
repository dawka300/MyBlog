@extends('layouts.app-backend')

@section('content')
    {!! Form::open(['action'=>['TopicsController@update', 'id'=>$topic->id], 'method'=>'put']) !!}
    <div class="form-group">
        {{Form::label('topic', 'Wpisz temat')}}
        {{Form::text('topic', $topic->topic ?? null, ['class'=>['form-control']])}}
    </div>
    {{form::submit('Zapisz', ['class'=>['btn', 'btn-success']])}}
    {{Form::close()}}


@endsection
