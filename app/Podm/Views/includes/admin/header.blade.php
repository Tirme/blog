<header class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo center">小布與噗噗</a>
            <a href="#" data-activates="podm-nav" class="menu-collapse">
                <i class="material-icons">menu</i>
            </a>
            <ul class="side-nav" id="podm-nav">
                @define $menu_links = Podm::getMenuLinks()
                @foreach ($menu_links as $menu_link)
                <li>
                    <a href="{{ $menu_link['link'] }}">{{ $menu_link['text'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
