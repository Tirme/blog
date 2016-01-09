<!DOCTYPE html>
<html ng-app="AdminModel">
    <head>
        <base href="/" />
        <title>GCR DataCenter</title>
        @include('includes.head')
    </head>
    <body>
        <div class="container">
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