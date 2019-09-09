@extends('layouts.app-backend')

@section('content')
{!! Form::open(['action'=>'TopicsController@store', 'method'=>'post']) !!}
    <div class="form-group">
        {{Form::label('topic', 'Wpisz temat')}}
        {{Form::text('topic', null, ['class'=>['form-control']])}}
    </div>
{{form::submit('Zapisz', ['class'=>['btn', 'btn-success']])}}
    {{Form::close()}}


@endsection
