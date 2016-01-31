<textarea
    class="materialize-textarea"
    id="{{ unique() }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    rows="{{ $rows }}"
    {{ $required }}
    {{ $editable }}
>{{ $value }}</textarea>
<label for="{{ unique() }}">{{ $label }}</label>