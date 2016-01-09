<label class="control-label">{{ $label }}</label>
<div>
    @foreach ($items as $item_value => $item_text)
        @if ($vertical)
            @define $class = 'radio'
        @else
            @define $class = 'radio-inline'
        @endif
        <div class="{{ $class }}">
            <label>
                @if ($item_value == $value)
                    <input
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $item_value }}"
                        checked="checked"
                    />
                @else
                    <input
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $item_value }}"
                    />
                @endif
                <span>{{ $item_text }}</span>
            </label>
        </div>
    @endforeach
</div>
