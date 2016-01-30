<!DOCTYPE html>
<html>
    <head>
        <base href="/" />
        <title>Blog - Admin Panel</title>
        @include('PodmView::includes.head')
    </head>
    <body>
        @include('PodmView::includes.admin.header')
        <div class="row">
            <div class="col s12 l12">
                @yield('content')
            </div>
        </div>
        @include('PodmView::includes.admin.footer')
        @include('PodmView::includes.foot')
    </body>
</html>
