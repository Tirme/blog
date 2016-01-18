<!DOCTYPE html>
<html ng-app="AdminModel">
    <head>
        <base href="/" />
        <title>Blog - Admin Panel</title>
        @include('FieldsView::includes.head')
    </head>
    <body>
        <div class="container-fluid">
            <div class="col-md-2">
                @yield('menu')
            </div>
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
        @include('FieldsView::includes.foot')
    </body>
</html>
