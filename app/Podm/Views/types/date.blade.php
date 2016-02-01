<div class="col s12">
    <div class="section">
        <label for="{{ Podm::uniqid(true) }}">{{ $label }}</label>
        <input
            id="{{ Podm::uniqid() }}"
            type="date"
            class="datepicker"
            name="{{$name}}"
            value="{{$value}}"
            {{$required}}
            {{$editable}}
            />
    </div>
</div>