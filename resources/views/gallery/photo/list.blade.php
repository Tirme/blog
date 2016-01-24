@extends('layouts.main')
@section('content')
    <section id="photo-list">
        <h3>{{ $album->name }}</h3>
        <div class="row">
            <photo_list :collection="{{ json_encode($photos) }}" inline-template>
                <div class="col s12 m4" v-for="photo in photos" v-bind:photo="photo">
                    <div class="card large hoverable">
                        <div class="card-image">
                            <img
                                src="@{{ photo.src }}"
                                title="@{{ photo.file_name }}"
                                data-caption="@{{ photo.date }}"
                                v-on:load="loaded"
                            />
                        </div>
                        <div class="card-content">
                            <p>@{{ photo.summary }}</p>
                            <h6>@{{ photo.make }} - @{{ photo.model }}</h6>
                            <div class="row">
                                <div class="col s12">鏡頭：@{{ photo.shot }}</div>
                                <div class="col s6">光圈：F@{{ photo.f_number }}</div>
                                <div class="col s6">快門：@{{ photo.exposure_time }}</div>
                                <div class="col s6">焦距：@{{ photo.focal_length }}</div>
                                <div class="col s6">ISO：@{{ photo.iso }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </photo_list>
        </div>
    </section>
    {{-- Blade Template --}}
    {{-- @foreach ($photos as $photo)
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
    @endforeach --}}
@endsection
