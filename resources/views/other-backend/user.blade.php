@extends('layouts.app-backend')

@section('content')
    {{--    {{dd($user)}}--}}
    @include('inc.error')
    {!! Form::open(['action'=>['UsersController@update', 'id'=>$user->id], 'method'=>'PUT', 'class'=>'text-white']) !!}
    <div class="from-group">
        <h3>Twoje imię i nazwisko</h3>
        {{Form::text('name', $user->name, ['class'=>'form-control'])}}
    </div>
    <div class="from-group">
        <h3>Twój nickname</h3>
        {{Form::text('nickname', $user->nickname, ['class'=>'form-control'])}}
    </div>
    <div class="form-group">
        <h3 class="text-white">O mnie</h3>
        {{Form::textarea('about', $user->about ?? null, ['class'=>['form-control'], 'id'=>'content', 'rows'=>70])}}
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <h3 class="text-white">Wybierz duże zdjęcie</h3>
            <div class="input-group">

           <span class="input-group-btn">
             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
               <i class="fa fa-picture-o"></i> Wybierz
             </a>
           </span>
                <input id="thumbnail" class="form-control" type="text"
                       name="main_filepath" {{$user->main_photo ? 'value='.$user->main_photo : null}}>
            </div>
            <img id="holder"
                 style="margin-top:15px;max-height:250px;"{{$user->main_photo ? 'src='.asset('storage/'.$user->main_photo) : null}} >
        </div>
        <div class="col-6">
            <h3 class="text-white">Wybierz portretowe zdjęcie</h3>
            <div class="input-group">

   <span class="input-group-btn">
     <a id="lfm2" data-input="thumbnail2" data-preview="holder" class="btn btn-primary text-white">
       <i class="fa fa-picture-o"></i> Wybierz
     </a>
   </span>
                <input id="thumbnail2" class="form-control" type="text"
                       name="tiny_filepath" {{$user->tiny_photo ? 'value='.$user->tiny_photo : null}}>
            </div>
            <img id="holder2"
                 style="margin-top:15px;max-height:250px;"{{$user->tiny_photo ? 'src='.asset('storage/'.$user->tiny_photo) : null}} >
        </div>
    </div>

    <div class="row mt-2">
        {{Form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
    </div>
    {!! Form::close() !!}
    <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#lfm, #lfm2').filemanager('image');
            $('#thumbnail, #thumbnail2').change(function () {
                let pathToFile = $(this).val();
                if ($(this).prop('id') === 'thumbnail') {
                    $('#holder').attr('src', pathToFile);
                } else {
                    $('#holder2').attr('src', pathToFile);
                }

                $(this).val(pathToFile.slice(pathToFile.indexOf('photos/'), pathToFile.length));

            });
        });

    </script>


@endsection
