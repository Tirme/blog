<section>
    <table class="responsive-table highlight bordered">
        <thead>
            <tr>
                @foreach ($columns as $key => $column)
                <th data-field>{{ $column }}</th>
                @endforeach
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
            <tr>
                @foreach ($columns as $key => $column)
                <td>{!! $row->$key->getContent() !!}</td>
                @endforeach
                <td>{{ $row->created_at }}</td>
                <td>{{ $row->updated_at }}</td>
                <td>
                    @foreach ($actions as $action)
                    <a href="{{ Podm::listLink($action['link'], $row) }}" title="{{ $action['title'] }}">
                        <i class="material-icons">{{ $action['class'] }}</i>
                    </a>
                    @endforeach
                    <a href="{{ $row->links->edit_form }}">
                        <i class="material-icons">mode_edit</i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ (count($columns) + 3) }}" class="empty">Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="section row">
        <div class="col s12 l12">
            <ul class="pagination right-align">
                @if ($pagination->currentPage() > 1)
                <li class="waves-effect">
                    <a href="{{ $pagination->previousPageUrl() }}">
                        <i class="material-icons">chevron_left</i>
                    </a>
                </li>
                @endif
                @for ($page = 1; $page <= $pagination->lastPage(); $page++)
                    @if ($pagination->currentPage() === $page)
                        <li class="active"><a href="{{ $pagination->url($page) }}">{{ $page }}</a></li>
                    @else
                        <li class="waves-effect"><a href="{{ $pagination->url($page) }}">{{ $page }}</a></li>
                    @endif
                @endfor
                @if ($pagination->currentPage() !== $pagination->lastPage())
                <li class="waves-effect">
                    <a href="{{ $pagination->nextPageUrl() }}">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <!--    <div class="panel panel-info">
             Default panel contents 
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h4>
                            <span>{{ $admin_name }}</span>
                            <span class="label badge">Records: {{ $pagination->total() }}</span>
                        </h4>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <form method="get" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search" value="{{ Request::query('search', '') }}" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <div class="btn-group">
                            <a href="{{ $links->create_form }}" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-th"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($columns as $key => $column)
                                <li>
                                    <a href="javascript: void(0);">
                                        <input type="checkbox" id="columns['{{ $key }}']" />
                                        <label for="columns['{{ $key }}']">{ {$column }}</label>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty($admin_description))
            <div class="panel-body">
                {{ $admin_description }}
            </div>
            @endif
            <table class="table table-hover">
                <thead>
                    <tr class="info">
                        @foreach ($columns as $key => $column)
                        <th>{{ $column }}</th>
                        @endforeach
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $row)
                    <tr>
                        @foreach ($columns as $key => $column)
                        <td>{!! $row->$key->getContent() !!}</td>
                        @endforeach
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->updated_at }}</td>
                        <td>
                            @foreach ($actions as $action)
                            <a href="{{ Podm::listLink($action['link'], $row) }}" title="{{ $action['title'] }}">
                                <span class="{{ $action['class'] }}"></span>
                            </a>
                            @endforeach
                            <a href="{{ $row->links->edit_form }}">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="{{$row->links->remove}}"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ (count($columns) + 3) }}" class="empty">Empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="clearfix">
            <div class="pull-right">
                {!! $pagination->render() !!}
            </div>
        </div>-->
</section>