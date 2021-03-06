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

        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="ti ti-bell"></i></span><span class="badge badge-deeporange">2</span></a>
            <div class="dropdown-menu notifications arrow">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="scroll-pane">
                    <ul class="media-list scroll-content">
                        <li class="media notification-success">
                            <a href="#">
                                <div class="media-left">
                                    <span class="notification-icon"><i class="ti ti-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="notification-heading">Update 1.0.4 successfully pushed</h4>
                                    <span class="notification-time">8 mins ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="media notification-info">
                            <a href="#">
                                <div class="media-left">
                                    <span class="notification-icon"><i class="ti ti-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="notification-heading">Update 1.0.3 successfully pushed</h4>
                                    <span class="notification-time">24 mins ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="media notification-teal">
                            <a href="#">
                                <div class="media-left">
                                    <span class="notification-icon"><i class="ti ti-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="notification-heading">Update 1.0.2 successfully pushed</h4>
                                    <span class="notification-time">16 hours ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="media notification-indigo">
                            <a href="#">
                                <div class="media-left">
                                    <span class="notification-icon"><i class="ti ti-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="notification-heading">Update 1.0.1 successfully pushed</h4>
                                    <span class="notification-time">2 days ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="media notification-danger">
                            <a href="#">
                                <div class="media-left">
                                    <span class="notification-icon"><i class="ti ti-arrow-up"></i></span>
                                </div>
                                <div class="media-body">
                                    <h4 class="notification-heading">Initial Release 1.0</h4>
                                    <span class="notification-time">4 days ago</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
<!-- 
        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-fullscreen"></i></span></i></a>
        </li> -->

        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                @if (!Request::is('noncust-ads*'))
                <img class="img-circle" src="{{ Auth::customer()->get()->gravatar }}" alt="" />
                @else
                <span class="icon-bg"><i class="ti ti-fullscreen"></i>
                @endif
            </a>
            <ul class="dropdown-menu userinfo arrow">
                @if (!Request::is('noncust-ads*'))
                    <li><a href="{{ url('account/edit_info') }}"><i class="ti ti-user"></i><span>Profile</span></a></li>
                    <!--<li><a href="#/"><i class="ti ti-panel"></i><span>Account</span></a></li>
                    <li><a href="#/"><i class="ti ti-settings"></i><span>Settings</span></a></li>
                    <li class="divider"></li>
                    <li><a href="#/"><i class="ti ti-view-list-alt"></i><span>Statement</span></a></li>-->
                    <li class="divider"></li>
                    <li><a href="{{ url('auth-customers/logout') }}"><i class="ti ti-shift-right"></i><span>Sign Out</span></a></li>
                @else
                    <li><a href="{{ url('noncust-ads/logout') }}"><i class="ti ti-shift-right"></i><span>Sign Out</span></a></li>
                @endif
            </ul>
        </li>

    </ul>
</header>