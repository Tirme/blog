@extends('PodmView::layout')
@section('content')
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
    <input type="hidden" name="_hash" value="{{ $hash }}" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <a href="{{ $links->cancel }}" class="btn btn-default">Cancel</a>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection