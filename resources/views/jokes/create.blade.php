@extends('layouts.app-backend')


@section('content')
    @error('content')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
    {!! Form::open(['action'=>'JokesController@store', 'method'=>'post']) !!}
    <div class="form-group">
        {{Form::label('content', 'Wpisz dowcip')}}
        {{Form::textarea('content', null, ['class'=>'form-control'])}}
    </div>
    <div class="form-group">
        <div class="text-center">
            <button type="submit" class="btn btn-success">Zapisz dowcip</button>
        </div>
    </div>
    {!! Form::close() !!}


@endsection
