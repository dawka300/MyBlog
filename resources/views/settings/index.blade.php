@extends('layouts.app-backend')


@section('content')
    @include('inc.error')
    {!! Form::open(['action'=>'SettingsController@store', 'method'=>'put']) !!}

    <div class="form-group">
        <h3 class="text-white">E-mail</h3>
        {{Form::text('email', $settings->email ?? null, ['class'=>'form-control'] )}}
    </div>
    <div class="form-group">
        <h3 class="text-white">Facebook</h3>
        {{Form::text('fb', $settings->fb ?? null, ['class'=>'form-control'] )}}
    </div>
    <div class="form-group">
        <h3 class="text-white">Twitter</h3>
        {{Form::text('twitter', $settings->twitter ?? null, ['class'=>'form-control'] )}}
    </div>
    <div class="form-group">
        <h3 class="text-white">YouTube</h3>
        {{Form::text('yt', $settings->yt ?? null, ['class'=>'form-control'] )}}
    </div>
    <div class="form-group">
        <h3 class="text-white">Konto bankowe</h3>
        {{Form::number('account', $settings->account ?? null, ['class'=>'form-control'] )}}
    </div>
    <div class="row mt-2">
        {{Form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
    </div>
    {{Form::close()}}

@endsection
