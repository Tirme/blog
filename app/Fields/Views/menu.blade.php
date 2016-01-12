<ul class="nav nav-pills nav-stacked">
    @foreach ($models as $model)
        @if (Request::segment(2) === $model->name)
            <li class="active">
                <a href="{{$model->link}}">{{$model->text}}</a>
            </li>
        @else
            <li>
                <a href="{{$model->link}}">{{$model->text}}</a>
            </li>
        @endif
    @endforeach
</ul>
