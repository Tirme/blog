@foreach ($errors as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert alert-danger">{{ $message }}</div>
    @endforeach
@endforeach
<form class="{{ $attributes['class'] }}" method="post" action="{{ $links->form_action }}">
    @foreach ($rows as $name => $row)
        @if ($row->isRequired())
            <div class="form-group" required="required">
                {!! $row->getFormHtml() !!}
            </div>
        @else
            <div class="form-group">
                {!! $row->getFormHtml() !!}
            </div>
        @endif
    @endforeach
    <input type="hidden" name="hash" value="{{ $hash }}" />
    <a href="{{ $links->cancel }}" class="btn btn-default">Cancel</a>
    {{ csrf_field() }}
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
