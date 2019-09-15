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
    <h3 class="text-white">Wybierz zdjęcie przewodnie</h3>
    <div class="input-group">

   <span class="input-group-btn">
     <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
       <i class="fa fa-picture-o"></i> Wybierz
     </a>
   </span>
        <input id="thumbnail" class="form-control" type="text" name="filepath" {{$settings->photo1 ? 'value='.$settings->photo1 : null}}>
    </div>
    <img id="holder" style="margin-top:15px;max-height:200px;"{{$settings->photo1 ? 'src=http://localhost/public/storage/'.$settings->photo1 : null}} >
   {{-- <div class="row">
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
    </div>--}}
    <div class="row mt-2">
        {{Form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
    </div>
    {{Form::close()}}
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $('#lfm').filemanager('image');
        $('#thumbnail').change(function () {
            let pathToFile=$(this).val();
            $('#holder').attr('src', pathToFile);
            $(this).val(pathToFile.slice(pathToFile.indexOf('photos/'), pathToFile.length));

        });

    </script>

@endsection
