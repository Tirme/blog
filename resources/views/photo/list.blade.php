<form method="post" action="">
    <ul class="photo-list">
        @foreach ($photos as $photo)
            <li>
                <img src="{{ route('gallery_album_photo_display', [
                    'album_id' => $photo->album_id,
                    'photo_id' => $photo->id
                ]) }}" />
                <p>{{ $photo->summary }}</p>
            </li>
        @endforeach
    </ul>
</form>
