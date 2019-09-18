@extends('layouts.app-backend')



@section('content')
    <a href="{{route('posts.create')}}" class="btn btn-primary">Dodaj wpis</a>
    <table class="table table-dark mt-4">
        <thead>
        <tr>
            <th>No</th>
            <th>Temat</th>
            <th>Operacje</th>
        </tr>
        </thead>
        <tbody>
        @if(count($posts)>0)
            @foreach($posts as $key => $post)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$post->topic}}</td>
                    <td><a href="{{route('topics.edit', ['id'=>$post->id])}}" class="btn btn-info">Edytuj</a> </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection
