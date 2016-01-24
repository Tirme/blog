<div>
    <a href="{{ route('admin_gallery_album_photo_form', [
        'album_id' => $album->id
    ]) }}">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<form method="post" action="{{ $form->action }}">
    <ul class="photo-list clearfix">
        @foreach ($photos as $photo)
            <li>
                <div>
                    <img src="{{ route('admin_gallery_album_photo_display', [
                        'album_id' => $photo->album_id,
                        'photo_id' => $photo->_id,
                        'size' => 'small'
                    ]) }}" />
                </div>
                <div class="form-group">
                    <select class="form-control" name="photos[{{ $photo->getId() }}][album_id]">
                        <option value="">移出相簿</option>
                        @foreach ($albums as $album)
                            <option value="{{ $album->getId() }}"
                                @if ($album->getId() === $photo->album_id)
                                    selected="selected"
                                @endif
                            >{{ $album->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="photos[{{ $photo->getId() }}][summary]">{{ $photo->summary }}</textarea>
                </div>
            </li>
        @endforeach
    </ul>
    <hr />
    <div class="clearfix">
        {{ $photos->render() }}
        <button type="submit" class="btn btn-primary pull-right">Save</button>
    </div>
    <input name="_method" type="hidden" value="PUT" />
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
</form>
