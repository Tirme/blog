@extends('layouts.main')
@section('content')
    <h3>{{ $album->name }}</h3>
    <div class="row">
        @foreach ($photos as $photo)
            <div class="col s12 m4">
                <div class="card large hoverable">
                    <div class="card-image">
                        <img class="materialboxed" src="{{ route('gallery_album_photo_display', [
                            'album_id' => $photo->album_id,
                            'photo_id' => $photo->id,
                            'size' => 'large'
                        ]) }}" data-caption="
                            @if (empty($photo->summary))
                                {{ $photo->date }}
                            @else
                                {{ $photo->summary }}
                            @endif
                        " title="{{ $photo->file_name }}">
                    </div>
                    <div class="card-content">
                        <p>
                            @if (empty($photo->summary))
                                {{ $photo->date }}
                            @else
                                {{ $photo->summary }}
                            @endif
                        </p>
                        <h6>{{ $photo->make }} - {{ $photo->model }}</h6>
                        <div class="row">
                            <div class="col s12">鏡頭：{{ $photo->shot }}</div>
                            <div class="col s6">光圈：F{{ $photo->f_number }}</div>
                            <div class="col s6">快門：{{ $photo->exposure_time }}</div>
                            <div class="col s6">焦距：{{ $photo->focal_length }}</div>
                            <div class="col s6">ISO：{{ $photo->iso }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
