<label class="control-label">{{ $label }}</label>
<input
    type="date"
    class="form-control"
    name="{{$name}}"
    value="{{$value}}"
    placeholder="{{$placeholder}}"
    {{$required}}
    {{$editable}}
/>
