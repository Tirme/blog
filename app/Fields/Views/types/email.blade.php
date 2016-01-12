<label class="control-label">{{ $label }}</label>
<input
    type="email"
    class="form-control"
    name="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    {{ $required }}
    {{ $editable }}
/>
