@extends('PodmView::layout')
@section('content')
<div class="podm-list">
    <div class="fixed-action-btn horizontal click-to-toggle list-action-btn">
        <a class="btn-floating btn-large">
            <i class=" material-icons">more_horiz</i>
        </a>
        <ul>
            <li>
                <a class="btn-floating light-blue" href="{{ route('model_create', ['model_name' => $model_name])}}">
                    <i class="material-icons">add</i>
                </a>
            </li>
            <li>
                <a class="btn-floating lime">
                    <i class="material-icons">search</i>
                </a>
            </li>
        </ul>
    </div>
    {!! $content !!}
</div>
@endsection