@extends('layouts.app-backend')

@section('content')
<iframe src="{{url('/laravel-filemanager?type=image')}}" style="width: 100%; height: 800px; overflow: hidden; border: none;"></iframe>
@endsection
