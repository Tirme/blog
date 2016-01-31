<div class="input-field">
    <input
        type="email"
        class="validate"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $required }}
        {{ $editable }}
        />
    <label for="{{ $name }}">{{ $label }}</label>
</div>