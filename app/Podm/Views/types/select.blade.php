<label class="control-label">{{ $label }}</label>
<select name="{{ $name }}" class="form-control">
    @foreach ($options as $value => $text)
        @if ($value == $selected_value)
            <option value="{{ $value }}" selected="selected">{{ $text }}</option>
        @else
            <option value="{{ $value }}" >{{ $text }}</option>
        @endif
    @endforeach
</select>
