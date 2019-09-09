@extends('layouts.app-backend')


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['action'=>'SettingsController@store', 'method'=>'put', 'files'=>true]) !!}
    <div class="form-group">
        <h3 class="text-white">O mnie</h3>
        {{Form::textarea('content', $settings->about ?? null, ['class'=>['form-control'], 'id'=>'content', 'rows'=>70])}}
    </div>
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
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <h3 class="text-white">Twoje zdjęcie</h3>
                {{Form::file('photo1')}}
            </div>
            @if(!empty($settings->photo1))
                <img  class="img-thumbnail own-photo" src="{{asset('storage/photos/admin/'.$settings->photo1)}}" alt="Moje foto">
            @endif
        </div>
        <div class="col-6">
            <div class="form-group">
                <h3 class="text-white">Twoje dodatkowe zdjęcie</h3>
                {{Form::file('photo2')}}
            </div>
            @if(!empty($settings->photo2))
                <img  class="img-thumbnail own-photo" src="{{asset('storage/photos/admin/'.$settings->photo2)}}" alt="Moje foto">
            @endif
        </div>
    </div>
    <div class="row mt-2">
        {{Form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
    </div>
    {{Form::close()}}

@endsection
