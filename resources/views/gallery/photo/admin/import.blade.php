<h5>相簿管理 - 批次處理</h5>
@if ($errors !== null)
@foreach ($errors->toArray() as $type => $messages)
@foreach ($messages as $message)
<div class="alert alert-danger">{{ $message }}</div>
@endforeach
@endforeach
@endif
<form id="photos-import" class="photos-import" method="post" action="{{ $form->action }}">
    {!! $form->album->getFormHtml() !!}
    <div class="row">
        @foreach ($photos as $photo)
        <div class="col s12 m4">
            <div class="card small hoverable">
                <div class="card-image">
                    <img
                        src="{{ route('admin_gallery_album_photo_import_display', [
                            'photo_id' => $photo->getId(),
                            'size' => 'small'
                        ]) }}"
                        class="materialboxed"
                        title="{{ $photo->file_name }}"
                        data-caption="{{ $photo->date }}"
                        />
                </div>
                <div class="card-content">
                    <div>
                        <input type="checkbox" id="bypass-{{ $photo->getId() }}" name="photos[{{ $photo->getId() }}][import]" value="1" />
                        <label for="bypass-{{ $photo->getId() }}">上傳</label>
                    </div>
                    <div class="right-align">
                        <span>拍攝日期：{{ $photo->date }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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
            <input type="hidden" name="date" value="{{ $date }}" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
    </div>
</form>