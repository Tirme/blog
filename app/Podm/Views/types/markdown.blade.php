@define $id = uniqid()
<div id="markdown-{{ $id }}" class="row markdown-editor">
    <div class="col s6">
        <ul class="tabs">
            <li class="tab col s6">
                <a href="#markdown-editor">Editor</a>
            </li>
            <li class="tab col s6">
                <a href="#markdown-preview">Preview</a>
            </li>
        </ul>
    </div>
    <div id="markdown-editor" class="col s12">
        <textarea
            class="col s12 materialize-textarea"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}"
            v-model="input_{{ $id }}"
            debounce="300"
            {{ $required }}
            {{ $editable }}
            >{{ $value }}</textarea>
    </div>
    <div id="markdown-preview" class="col s12">
        <div class="markdown-preview" v-html="input_{{ $id }} | marked"></div>
    </div>
</div>
@push('podm-scripts')
    new Vue({
        el: '#markdown-{{ $id }}',
        data: {
            'input_{{ $id }}': ''
        },
        filters: {
            marked: marked
        }
    });
@endpush
