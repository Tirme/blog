<div class="row">
    <div class="input-field col s12 m6 l4">
        <input
            type="text"
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
</div>
