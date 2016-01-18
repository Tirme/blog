<div>
    <a href="{{ route('gallery_album_photo_form', [
        'album_id' => $album->id
    ]) }}">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<form method="post" action="">
    <ul class="photo-list clearfix">
        @foreach ($photos as $photo)
            <li>
                <div>
                    <img src="{{ route('gallery_album_photo_display', [
                        'album_id' => $photo->album_id,
                        'photo_id' => $photo->id
                    ]) }}" />
                </div>
                <p>{{ $photo->summary }}</p>
            </li>
        @endforeach
    </ul>
</form>
