@extends('layouts.app-backend')

@section('content')
{!! Form::open(['action'=>'TagsController@store', 'method'=>'post']) !!}
    <div class="form-group">
        {{Form::label('tag', 'Podaj Tag')}}
        {{Form::text('tag', null, ['class'=>['form-control']])}}
    </div>
{{form::submit('Zapisz', ['class'=>['btn', 'btn-success']])}}
    {{Form::close()}}

<div style="height: 600px;">
    <div id="fm"></div>
</div>
@endsection
