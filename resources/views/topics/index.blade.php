@extends('layouts.app-backend')



@section('content')
    <a href="{{route('topics.create')}}" class="btn btn-primary">Dodaj temat</a>
    <table class="table table-dark mt-4">
        <thead>
        <tr>
            <th>No</th>
            <th>Temat</th>
            <th>Operacje</th>
        </tr>
        </thead>
        <tbody>
        @if(count($topics)>0)
            @foreach($topics as $key => $topic)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$topic->topic}}</td>
                    <td><a href="{{route('topics.edit', ['id'=>$topic->id])}}" class="btn btn-info">Edytuj</a> </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection
