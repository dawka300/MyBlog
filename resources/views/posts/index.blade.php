@extends('layouts.app-backend')



@section('content')
    <a href="{{route('posts.create')}}" class="btn btn-primary">Dodaj wpis</a>
    <table class="table table-dark mt-4">
        <thead>
        <tr>
            <th>No</th>
            <th>Obrazek</th>
            <th>Temat</th>
            <th>Treść</th>
            <th>Operacje</th>
        </tr>
        </thead>
        <tbody>
        @if(count($posts)>0)
            @foreach($posts as $key => $post)
                <tr>
                    <td>{{$key+1}}</td>
                    <td><img width="120px" height="120px" alt="{{$post->title}}" src="{{asset('storage/'.$post->thumbnail)}}"></td>
                    <td><i>{{$post->title}}</i></td>
                    <td>{!!Str::limit($post->content, 200, '...')!!}</td>
                    <td><a href="{{route('posts.edit', ['id'=>$post->id])}}" class="btn btn-info">Edytuj</a> </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection
