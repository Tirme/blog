<!DOCTYPE html>
<html>
    <head>
        <base href="/" />
        <title>Blog</title>
        @include('includes.head')
    </head>
    <body>
        @include('includes.main.header')
        <div class="row">
            <div class="col m2 l2">&nbsp;</div>
            <div class="col s12 m8 l8 waves-effect waves-red">
                <div class="card-panel red lighten-4">
                    <div class="white-text center-align">旅遊、工作，工作、旅遊</div>
                </div>
            </div>
            <div class="col m2 l2">&nbsp;</div>
        </div>
        <div class="divider"></div>
        <div class="section">
            @yield('content')
        </didv>
        @include('includes.main.footer')
        @include('includes.foot')
    </body>
</html>
