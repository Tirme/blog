<!DOCTYPE html>
<html ng-app="AdminModel">

<head>
    <base href="/" />
    <title>Blog - Admin Panel</title>
    @include('PodmView::includes.head')
</head>

<body>
    @include('PodmView::includes.admin.header')
    <div class="container-fluid">
        <div class="col-md-2">
            @yield('menu')
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
    @include('PodmView::includes.admin.footer')
    @include('PodmView::includes.foot')
</body>

</html>
