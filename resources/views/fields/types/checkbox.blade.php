<label class="control-label">{{ $label }}</label>
<div>
    @foreach ($items as $value => $text)
        @if ($vertical)
            @define $class = 'checkbox'
        @else
            @define $class = 'checkbox-inline'
        @endif
        <div class="{{ $class }}">
            <label>
                @if (in_array($value, $values))
                    <input
                        type="checkbox"
                        name="{{ $name }}[]"
                        value="{{ $value }}"
                        checked="checked"
                        />
                @else
                    <input
                        type="checkbox"
                        name="{{ $name }}[]"
                        value="{{ $value }}"
                        />
                @endif
                <span>{{ $text }}</span>
            </label>
        </div>
    @endforeach
</div>
