<label class="control-label">{{ $label }}</label>
<input
    type="file"
    accept="image/*"
    multiple
    model_name="{{ $model_name }}"
    id="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    {{ $required }}
/>
<ul class="photos-form clearfix"></ul>
