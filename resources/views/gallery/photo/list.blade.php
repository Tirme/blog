@extends('layouts.blog')
@section('content')
    <div class="row">
        @foreach ($photos as $photo)
            <div class="col s12 m4">
                <div class="card hoverable">
                    <div class="card-image">
                        <img class="responsive-img materialboxed" src="{{ route('gallery_album_photo_display', [
                            'album_id' => $photo->album_id,
                            'photo_id' => $photo->id
                        ]) }}" data-caption="{{ $photo->summary }}">
                    </div>
                    <div class="card-content">
                        <p>{{ $photo->summary }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
