<header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">
    <div class="logo-area">
        <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
            <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
                <span class="icon-bg">
                    <i class="ti ti-menu"></i>
                </span>
            </a>
        </span>
        
        <a class="navbar-brand" href="index.html">MyListing</a>

        <div class="toolbar-icon-bg hidden-xs" id="toolbar-search">
            <div class="input-group">
                <span class="input-group-btn"><button class="btn" type="button"><i class="ti ti-search"></i></button></span>
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn"><button class="btn" type="button"><i class="ti ti-close"></i></button></span>
            </div>
        </div>

    </div><!-- logo-area -->

    <ul class="nav navbar-nav toolbar pull-right">

        <li class="toolbar-icon-bg visible-xs-block" id="trigger-toolbar-search">
            <a href="#"><span class="icon-bg"><i class="ti ti-search"></i></span></a>
        </li>
        
        <li class="toolbar-icon-bg hidden-xs">
            <a href="#"><span class="icon-bg"><i class="ti ti-world"></i></span></i></a>
        </li>

        <li class="toolbar-icon-bg hidden-xs">
            <a href="#"><span class="icon-bg"><i class="ti ti-view-grid"></i></span></i></a>
        </li>

        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-fullscreen"></i></span></i></a>
        </li>

        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                <img class="img-circle" src="{{ Auth::user()->get()->gravatar }}" alt="" />
            </a>
            <ul class="dropdown-menu userinfo arrow">
                <li><a href="#/"><i class="ti ti-user"></i><span>Profile</span></a></li>
                <li><a href="#/"><i class="ti ti-panel"></i><span>Account</span></a></li>
                <li><a href="#/"><i class="ti ti-settings"></i><span>Settings</span></a></li>
                <li class="divider"></li>
                <li><a href="#/"><i class="ti ti-view-list-alt"></i><span>Statement</span></a></li>
                <li class="divider"></li>
                <li><a href="{{ url('app-admin/auth/logout') }}"><i class="ti ti-shift-right"></i><span>Sign Out</span></a></li>
            </ul>
        </li>

    </ul>
</header>