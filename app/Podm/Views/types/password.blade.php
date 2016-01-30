<div class="row">
    <div class="input-field col s12 m6 l4">
        <input
            type="password"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $required }}
            {{ $editable }}
            />
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
    <div class="input-field col s12 m6 l4">
        <input
            type="password"
            id="{{ $name }}-confirmation"
            name="{{ $name }}_confirmation"
            value="{{ $value }}"
            placeholder="Repeat password again"
            {{ $required }}
            {{ $editable }}
            />
        <label for="{{ $name }}-confirmation">Repeat Password</label>
    </div>
</div>