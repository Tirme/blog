<div>
    <a href="{{ route('admin_gallery_album_photo_form', [
        'album_id' => $album->id
    ]) }}">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<form method="post" action="{{ $form->action }}">
    <div class="row">
        @foreach ($photos as $photo)
        <div class="col s12 m4">
            <div class="card large hoverable">
                <div class="card-image">
                    <img
                        src="{{ route('admin_gallery_album_photo_display', [
                            'album_id' => $photo->album_id,
                            'photo_id' => $photo->_id,
                            'size' => 'small'
                        ]) }}"
                        class="materialboxed"
                        title="{{ $photo->file_name }}"
                        data-caption="{{ $photo->date }}"
                        />
                </div>
                <div class="card-content">
                    <div class="input-field">
                        <select name="photos[{{ $photo->getId() }}][album_id]">
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
                    <div class="input-field">
                        <textarea class="materialize-textarea" name="photos[{{ $photo->getId() }}][summary]">{{ $photo->summary }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <hr />
    <div class="section row">
        <div class="col s12 l12">
            <ul class="pagination right-align">
                @if ($photos->currentPage() > 1)
                <li class="waves-effect">
                    <a href="{{ $photos->previousPageUrl() }}">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
                @endif
                @for ($page = 1; $page <= $photos->lastPage(); $page++)
                    @if ($photos->currentPage() === $page)
                        <li class="active"><a href="{{ $photos->url($page) }}">{{ $page }}</a></li>
                    @else
                        <li class="waves-effect"><a href="{{ $photos->url($page) }}">{{ $page }}</a></li>
                    @endif
                @endfor
                @if ($photos->currentPage() !== $photos->lastPage())
                <li class="waves-effect">
                    <a href="{{ $photos->nextPageUrl() }}">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="center-align">
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
    </div>
    <input name="_method" type="hidden" value="PUT" />
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
</form>
