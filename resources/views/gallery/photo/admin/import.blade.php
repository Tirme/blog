<h1>相簿管理 - 批次處理</h1>
<hr />
<form id="photos-import" class="photos-import" method="post" action="{{ $form->action }}">
    {!! $form->album->getFormHtml() !!}
    <ul class="photos clearfix">
        @foreach ($photos as $index => $photo)
            <li>
                <div class="{{ $photo['direction'] }}">
                    <div>
                        <input type="checkbox" id="bypass-{{ $index }}" name="photos[{{ $index }}][import]" value="1" />
                        <label for="bypass-{{ $index }}">上傳</label>
                        <input type="checkbox" id="remove-{{ $index }}" name="photos[{{ $index }}][remove]" value="1" />
                        <label for="remove-{{ $index }}">刪除</label>
                    </div>
                    <img src="data:image/{{ $photo['mine_type'] }};base64,{{ $photo['base64'] }}" title="{{ $photo['$file_name'] }}" @click="open('{{ $folder_name }}', '{{ $photo['$file_name'] }}')" />
                </div>
                <input type="hidden" name="photos[{{ $index }}][id]" value="{{ $photo['$file_name'] }}" />
                <textarea name="photos[{{ $index }}][summary]" placeholder="寫點什麼吧"></textarea>
            </li>
        @endforeach
    </ul>
    <hr />
    <div class="clearfix">
        {!! $paginator->render() !!}
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
            open: function(folder_name, $file_name) {
                this.photo = '/admin/gallery/photos/import/display/' + folder_name + '/' + $file_name;
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
