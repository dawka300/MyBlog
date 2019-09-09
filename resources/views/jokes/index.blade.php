@extends('layouts.app-backend')


@section('content')
    <div class="row">
        <a href="{{route('jokes.create')}}" class="btn btn-primary">Dodaj nowy</a>
    </div>
<div class="row">
    <table class="table mt-2 table-dark table-hover">
        <thead>
        <th>No.</th>
        <th>Treść</th>
        <th>Operacje</th>
        </thead>
        <tbody>
        @if(count($jokes)>0)
        @foreach($jokes as $key => $joke)
        <tr>
            <td>{{$key+1}}</td>
            <td>{!!substr($joke->content, 0, 100).'...'!!}</td>
            <td>
                <div class="row">
                    <div class="col-6">
                <a class="btn btn-outline-primary btn-sm" href="{{route('jokes.edit', ['id'=>$joke->id])}}">Edytuj</a>
                    </div>
                    <div class="col-6">
            {!! Form::open(['action'=>['JokesController@destroy', 'id'=>$joke->id], 'method'=>'delete']) !!}
                {{Form::submit('Usuń', ['class'=>['btn', 'btn-outline-danger', 'btn-sm'], 'onclick'=>'return confirm("Czy na pewno chcesz usunąć wybrany dowcip?")'])}}
                {!! Form::close() !!}
                    </div>
                </div>
            </td>
        </tr>
        @endforeach

        @endif

        </tbody>
    </table>
</div>



@endsection
