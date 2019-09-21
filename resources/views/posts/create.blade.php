@extends('layouts.app-backend')

@section('content')
    @include('inc.error')
    {!! Form::open(['action'=>'PostsController@store', 'method'=>'post', 'class'=>'text-white']) !!}
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <h3>Wpisz temat artykułu</h3>
                {{Form::text('title', null, ['class'=>['form-control'], 'required'=>true])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Wybierz kategorię</h3>
                {{Form::select('category', $topics, null, ['class'=>['form-control']])}}
            </div>
        </div>
    </div>
    <h3>Wybierz tagi:</h3>
    <div class="row">
        <div class="col-8 ">
    @foreach($tags as $tag)

                <div class="form-check form-check-inline">
                    {{Form::checkbox('tags[]', $tag->id, null, ['class'=>['form-check-input', 'big-checkbox'],  'id'=>'tags'.$tag->id] )}}
                    {{Form::label('tags'.$tag->id, $tag->tag, ['class'=>['form-check-label', 'big-label-checkbox'], 'style'=>'color:#333;font-style:italic;'])}}
                </div>

    @endforeach
        </div>
    </div>
    <div class="form-group">
        <h3>Treść posta</h3>
        {{Form::textarea('content', null, ['class'=>['form-control'], 'id'=>'content'])}}
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <h3>Wpisz dane meta dla przeglądarek</h3>
                {{Form::text('meta_desc', null, ['class'=>['form-control'], 'required'=>true])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Wprowadź datę publikacji</h3>
                {{Form::date('date_public', new \DateTime(), ['class'=>['form-control'], 'required'=>true ])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Numer</h3>
                {{Form::number('number', $number+1 ?? null, ['class'=>['form-control'], 'required'=>true ])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <h3>Wyróżniony post</h3>
                {{Form::checkbox('marked',null, null, ['class'=>['form-control'] ])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h3 class="text-white">Wybierz zdjęcie - lead</h3>
            <div class="input-group">

           <span class="input-group-btn">
             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
               <i class="fa fa-picture-o"></i> Wybierz
             </a>
           </span>
                <input id="thumbnail" class="form-control" type="text"
                       name="lead">
            </div>
            <img id="holder"
                 style="margin-top:15px;max-height:250px;">
        </div>
        <div class="col-6">
           {{-- <h3 class="text-white">Wybierz zdjęcie - Lead FB</h3>
            <div class="input-group">

           <span class="input-group-btn">
             <a id="lfm2" data-input="thumbnail2" data-preview="holder" class="btn btn-primary text-white">
               <i class="fa fa-picture-o"></i> Wybierz
             </a>
           </span>
                <input id="thumbnail2" class="form-control" type="text"
                       name="lead_fb">
            </div>
            <img id="holder2"
                 style="margin-top:15px;max-height:250px;">--}}
        </div>
    </div>


    <div class="row mt-2">
        <div class="col-12">
          {{form::submit('Zapisz', ['class'=>['btn', 'btn-success', 'btn-block']])}}
        </div>
        </div>
    {{Form::close()}}
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
