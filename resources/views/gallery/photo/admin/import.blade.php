<h1>相簿管理 - 批次處理</h1>
<hr />
@if ($errors !== null)
    @foreach ($errors->toArray() as $type => $messages)
        @foreach ($messages as $message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endforeach
    @endforeach
@endif
<form id="photos-import" class="photos-import" method="post" action="{{ $form->action }}">
    {!! $form->album->getFormHtml() !!}
    <ul class="photos clearfix">
        @foreach ($photos as $photo)
            <li>
                <div class="{{ $photo['direction'] }}">
                    <div>
                        <input type="checkbox" id="bypass-{{ $photo->getId() }}" name="photos[{{ $photo->getId() }}][import]" value="1" />
                        <label for="bypass-{{ $photo->getId() }}">上傳</label>
                    </div>
                    <h5>{{ $photo['date'] }} F{{ $photo['f_number'] }}</h5>
                    <img src="{{ route('admin_gallery_album_photo_import_display', [
                        'photo_id' => $photo->getId(),
                        'size' => 'small'
                    ]) }}" @click="open('{{ $photo->getId() }}')" />
                </div>
                <input type="hidden" name="date" value="{{ $date }}" />
            </li>
        @endforeach
    </ul>
    <hr />
    <div class="clearfix">
        {!! $photos->render() !!}
        <button type="submit" class="btn btn-primary pull-right">Save</button>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <modal :show.sync="show_modal" title="Photo" effect="fade" width="990" class="vuestrap-bug-photo-import-modal">
        <div slot="modal-body" class="modal-body">
            <img src="@{{ photo }}" class="center-block" v-show="show_photo" v-on:load="photoLoaded"/>
            <progressbar :now="100" v-show="show_progressbar" type="primary" striped label animated></progressbar>
        </div>
        <div slot="modal-footer" class="modal-footer">
            <button type="button" class="btn btn-default" @click='show_modal = false'>Close</button>
        </div>
    </modal>
</form>
@push('fields-scripts')
    new Vue({
        el: '#photos-import',
        data: {
            show_modal: false,
            photo: '',
            show_photo: false,
            show_progressbar: false
        },
        methods: {
            open: function(photo_id) {
                this.photo = '/admin/gallery/photo/import/display/' + photo_id + '/size/medium';
                this.show_photo = false;
                this.show_progressbar = true;
                this.show_modal = true;
            },
            photoLoaded: function() {
                this.show_photo = true;
                this.show_progressbar = false;
            }
        },
        components: {
            modal: modal,
            progressbar: progressbar
        }
    });
@endpush
