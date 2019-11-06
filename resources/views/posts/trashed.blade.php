@extends('layouts.app-backend')



@section('content')
    <table class="table table-dark mt-4">
        <thead>
        <tr>
            <th>No</th>
            <th>Obrazek</th>
            <th>Temat</th>
            <th>Treść</th>
            <th>Wyróżniony</th>
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
                    <td>{{$post->marked==1 ? 'Tak' : 'Nie'}}</td>
                    <td><a href="{{route('posts.edit', ['id'=>$post->id])}}" class="btn btn-info">Edytuj</a>
                        <br>
                        <form action="{{action('PostsController@delete', ['id'=>$post->id])}}" method="post">
                            @method('delete')
                            @csrf
                            <button onclick="return confirm('Czy chcesz całkowicie usunąć wpis?')" class="btn btn-danger" type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection
