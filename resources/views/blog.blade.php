@extends('layouts.blog')
@section('content')
    @foreach($albums as $album)
        {{ $album->name }}
    @endforeach
@endsection
