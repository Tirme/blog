<label class="control-label">{{ $label }}</label>
<textarea
    class="form-control"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    rows="{{ $rows }}"
    {{ $required }}
    {{ $editable }}
>{{ $value }}</textarea>
