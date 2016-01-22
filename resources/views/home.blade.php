@extends('layouts.main')
@section('content')
    <div class="row">
        @foreach($albums as $album)
            <div class="col s12 m4">
                <div class="card medium hoverable">
                    <div class="card-image">
                        <a
                            href="{{ route('gallery_album_photo_list', [
                                'album_id' => $album->getId()
                            ]) }}"
                        >
                            @if ($album->cover)
                                <img src="{{ route('gallery_album_photo_display', [
                                    'album_id' => $album->getId(),
                                    'photo_id' => $album->cover->getId(),
                                    'size' => 'small'
                                ]) }}">
                            @endif
                            <span class="card-title">{{ $album->name }}</span>
                        </a>
                    </div>
                    <div class="card-content">
                        <p>{{ $album->summary }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
