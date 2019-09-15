@extends('layouts.app-backend')


@section('content')
    <a href="{{route('tags.create')}}" class="btn btn-primary">Dodaj Tag</a>
    <table class="table table-dark mt-4">
        <thead>
        <tr>
            <th>No</th>
            <th>Tag</th>
            <th>Operacje</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($tags) && count($tags)>0)
            @foreach($tags as $key => $tag)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$tag->tag}}</td>
                    <td><a href="{{route('tags.edit', ['id'=>$tag->id])}}" class="btn btn-info">Edytuj</a> </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection
