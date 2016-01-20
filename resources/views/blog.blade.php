@extends('layouts.main')
@section('content')
    @foreach($albums as $album)
        {{ $album->name }}
    @endforeach
@endsection
