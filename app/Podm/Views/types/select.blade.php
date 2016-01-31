<div class="input-field col s12">
    <select name="{{ $name }}">
        @foreach ($options as $value => $text)
        @if ($value == $selected_value)
        <option value="{{ $value }}" selected="selected">{{ $text }}</option>
        @else
        <option value="{{ $value }}" >{{ $text }}</option>
        @endif
        @endforeach
    </select>
    <label>{{ $label }}</label>
</div>