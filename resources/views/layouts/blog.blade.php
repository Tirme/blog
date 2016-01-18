<!DOCTYPE html>
<html ng-app="AdminModel">
    <head>
        <base href="/" />
        <title>Blog</title>
        @include('includes.fields.head')
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
        @include('includes.foot')
    </body>
</html>
