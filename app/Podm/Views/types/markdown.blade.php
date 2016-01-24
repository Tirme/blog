@define $id = uniqid()
<label class="control-label">{{ $label }}</label>
<div id="markdown-{{ $id }}" class="markdown-editor">
    <tabs>
        <tab header="Editor">
            <textarea
                class="form-control"
                name="{{ $name }}"
                placeholder="{{ $placeholder }}"
                rows="{{ $rows }}"
                v-model="input_{{ $id }}"
                debounce="300"
                {{ $required }}
                {{ $editable }}
            >{{ $value }}</textarea>
        </tab>
        <tab header="Preview">
            <div class="markdown-preview" v-html="input_{{ $id }} | marked"></div>
        </tab>
    </tabs>
</div>
@push('fields-scripts')
    new Vue({
        el: '#markdown-{{ $id }}',
        data: {
            'input_{{ $id }}': ''
        },
        filters: {
            marked: marked
        },
        components: {
            tabs: tabs,
            tab: tab
        }
    });
@endpush
