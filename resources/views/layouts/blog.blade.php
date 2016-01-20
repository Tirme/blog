<!DOCTYPE html>
<html ng-app="AdminModel">
    <head>
        <base href="/" />
        <title>Blog</title>
        @include('includes.head')
    </head>
    <body>
        <header class="navbar-fixed">
            <nav>
                <div class="nav-wrapper">
                    <a href="/" class="brand-logo center">在那邊</a>
                    <a href="#" data-activates="mobile-nav" class="button-collapse">
                        <i class="mdi-navigation-menu"></i>
                    </a>
                    <ul class="left hide-on-med-and-down">
                        <li>
                            <a href="/blog">Blog</a>
                        </li>
                        <li>
                            <a href="/gallery">Gallery</a>
                        </li>
                    </ul>
                    <ul class="side-nav" id="mobile-nav">
                        <li>
                            <a href="/blog">Blog</a>
                        </li>
                        <li>
                            <a href="/gallery">Gallery</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="row">
            <div class="col s12 m12 l12 waves-effect waves-red">
                <div class="card-panel red lighten-4">
                    <div class="white-text center-align">旅遊、工作，工作、旅遊</div>
                </div>
            </div>
        </div>
        @yield('content')
        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l12 m12 s12">
                        <h5 class="white-text">別忘了給我一個讚！</h5>
                    </div>

                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2016 Peter Tsai, All rights reserved.
                    <a class="grey-text text-lighten-4 right" href="https://github.com/tirme/blog">MIT License</a>
                </div>
            </div>
        </footer>
        @include('includes.foot')
    </body>
</html>
