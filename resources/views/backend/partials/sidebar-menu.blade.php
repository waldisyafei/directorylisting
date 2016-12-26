<div class="static-sidebar-wrapper sidebar-midnightblue">
    <div class="static-sidebar">
    	<div class="sidebar">
    		<!-- user info -->
			<div class="widget">
			    <div class="widget-body">
			        <div class="userinfo">
			            <div class="avatar">
			                <img src="{{ Auth::user()->get()->gravatar }}" class="img-responsive img-circle"> 
			            </div>
			            <div class="info">
			                <span class="username" style="display: block; margin-bottom: 5px;">{{ Auth::user()->get()->name }}</span>
			                <span class="useremail" style="display: block; text-transform: uppercase;">{{ Auth::user()->get()->email }}</span>
			            </div>
			        </div>
			    </div>
			</div>
    		<!-- /.end user info -->

    		<!-- Main menu -->
    		<div class="widget stay-on-collapse" id="widget-sidebar">
    			<nav role="navigation" class="widget-body">
    				<ul class="acc-menu">
    					<li class="nav-separator"><span>NAVIGATION MENU</span></li>
    					<li class="{{ Request::is('app-admin') ? 'active ' : null }}"><a href="{{ url('app-admin') }}"><i class="ti ti-home"></i><span>Dashboard</span></a></li>

                        @if (Auth::user()->get()->can('can_view_users'))
                            <!-- users menu -->
                            <li class="{{ Request::is('app-admin/users*') || Request::is('app-admin/roles*') ? 'active open' : null }}"><a href="javascript:;"><i class="ti ti-user"></i><span>Users</span></a>
                                <ul class="acc-menu"{!! Request::is('app-admin/users*') || Request::is('app-admin/roles*') ? ' style="display: block;"' : null !!}>
                                    <li class="{{ Request::is('app-admin/users') ? ' active' : null }}"><a href="{{ url('app-admin/users') }}">Users List</a></li>

                                    @if (Auth::user()->get()->can('can_view_roles'))
                                        <li class="{{ Request::is('app-admin/roles*') ? ' active' : null }}"><a href="{{ url('app-admin/roles') }}">Users Roles</a></li>
                                    @endif

                                    <li><a href="<?php echo url('app-admin/permissions') ?>">Permissions</a></li>
                                </ul>
                            </li>
                            <!-- /.end users menu -->
                        @endif

    					@if (Auth::user()->get()->can('can_view_listing'))
                            <!-- Listing -->
                            <li class="{{ Request::is('app-admin/listings*') ? 'active open' : null }}"><a href="javascript:;"><i class="ti ti-layout-list-thumb"></i><span>Listings</span></a>
                                <ul class="acc-menu" style="{{ Request::is('app-admin/listings*') ? 'display: block;' : null }}">
                                    <li class="{{ Request::is('app-admin/listings/create') ? 'active' : null }}"><a href="{{ url('app-admin/listings/create') }}">Create New Non Customer Listing</a></li>
                                    <li class="{{ Request::is('app-admin/listings/noncust') ? ' active' : null }}"><a href="{{ url('app-admin/listings/noncust') }}">Manage Non Customer Listing</a></li>
                                    <li class="{{ Request::is('app-admin/listings') ? ' active' : null }}"><a href="{{ url('app-admin/listings') }}">Listings Management</a></li>

                                    @if (Auth::user()->get()->can('can_view_all_category'))
                                    <li class="{{ Request::is('app-admin/listings/categories*') ? 'active' : null }}"><a href="{{ url('app-admin/listings/categories') }}">Categories</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

    					@if (Auth::user()->get()->can('can_view_ads'))
                            <!-- Ads -->
                            <li class="{{ Request::is('app-admin/ads*') ? 'active open' : null }}"><a href="javascript:;"><i class="ti ti-layout-accordion-list"></i><span>Ads</span></a>
                                <ul class="acc-menu" style="{{ Request::is('app-admin/ads*') ? 'display: block;' : null }}">
                                    <li class="{{ Request::is('app-admin/ads/create') ? 'active' : null }}"><a href="{{ url('app-admin/ads/create') }}">Create New Non Customer Ad</a></li>
                                    <li class="{{ Request::is('app-admin/ads/noncust') ? ' active' : null }}"><a href="{{ url('app-admin/ads/noncust') }}">Manage Non Customer Ad</a></li>
                                    <li class="{{ Request::is('app-admin/ads') ? ' active' : null }}"><a href="{{ url('app-admin/ads') }}">Ads Management</a></li>
                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->get()->can('can_approve_listing'))
                            <?php
                            $unapproved = getListings('checking')->count();
                            $unapproved = $unapproved + getAds('checking')->count();
                            ?>
                            <li class="{{ Request::is('app-admin/approvals*') ? ' active' : null }}"><a href="javascript:;"><i class="ti ti-check-box"></i><span>Approvals</span>{!! $unapproved > 0 ? ' <span class="badge badge-teal">'. $unapproved .'</span>' : null !!}</a>
                                <ul class="acc-menu"{!! Request::is('app-admin/approvals*') ? ' style="display: block"' : null !!}>
                                    <li class="{{ Request::is('app-admin/approvals/listings') ? 'active ' : null }}"><a href="<?php echo url('app-admin/approvals/listings') ?>">Listings</a></li>
                                    <li class="{{ Request::is('app-admin/approvals/ads') ? 'active ' : null }}"><a href="<?php echo url('app-admin/approvals/ads') ?>">Ads</a></li>
                                </ul>
                            </li>
                        @endif

    					@if (Auth::user()->get()->can('can_view_customers'))
                            <!-- Customers -->
                            <li class="{{ Request::is('app-admin/customers*') ? 'active ' : null }}"><a href="{{ url('app-admin/customers') }}"><i class="ti ti-id-badge"></i><span>Customers</span></a></li>
                        @endif

    					@if (Auth::user()->get()->can('can_view_billing'))
                            <?php
                            $unconfirmed = getListings('pending')->count();
                            $unconfirmed = $unconfirmed + getAds('pending')->count();
                            ?>
                            <!-- Billings -->
                            <li class="{{ Request::is('app-admin/billings*') ? 'open active' : null }}">
                                <a href="javascript:;"><i class="ti ti-receipt"></i><span>Billings</span>{!! $unconfirmed > 0 ? ' <span class="badge badge-teal">'. $unconfirmed .'</span>' : null !!}</a>
                                <ul class="acc-menu" {!! Request::is('app-admin/billings*') ? ' style="display: block;"' : null !!}>
                                    <li class="{{ Request::is('app-admin/billings/listing/*') ? 'active' : null }}"><a href="{{ url('app-admin/billings/listing') }}">Listing</a></li>
                                    <li><a href="{{ url('app-admin/billings/ads') }}">Ads</a></li>
                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->get()->can('can_create_package'))
                            <li class="{{ Request::is('app-admin/packages*') ? 'active' : null }}"><a href="{{ url('app-admin/packages') }}"><i class="ti ti-package"></i> Packages</a></li>
                        @endif

    					@if (Auth::user()->get()->can('can_edit_system'))
                            <!-- System settings -->
                            <li class="{{ Request::is('app-admin/settings*') ? 'active' : null }}"><a href="javascript:;"><i class="ti ti-settings"></i><span>System Settings</span></a>
                                <ul class="acc-menu" style="{{ Request::is('app-admin/settings*') ? 'display: block;' : null }}">
                                    <li class="{{ Request::is('app-admin/settings/site') ? 'active' : null }}"><a href="{{ url('app-admin/settings/site') }}">Site</a></li>
                                    <li class="{{ Request::is('app-admin/settings/packages') ? 'active' : null }}"><a href="{{ url('app-admin/settings/packages') }}">Packages</a></li>
                                    <li class="{{ Request::is('app-admin/settings/listings') ? 'active' : null }}"><a href="{{ url('app-admin/settings/listings') }}">Listings</a></li>
                                    <li class="{{ Request::is('app-admin/settings/ads') ? 'active' : null }}"><a href="{{ url('app-admin/settings/ads') }}">Ads</a></li>
                                    <li class="{{ Request::is('app-admin/settings/ads-price') ? 'active' : null }}"><a href="{{ url('app-admin/settings/ads-price') }}">Ads Price</a></li>
                                </ul>
                            </li>
                        @endif
    				</ul>
    			</nav>
    		</div>
    		<!-- /.end Main menu -->

    		<!-- System status -->
    		<div class="widget" id="widget-progress">
		        <div class="widget-heading">
		            Progress
		        </div>
		        <div class="widget-body">

		            <div class="mini-progressbar">
		                <div class="clearfix mb-sm">
		                    <div class="pull-left">Bandwidth</div>
		                    <div class="pull-right">50%</div>
		                </div>
		                
		                <div class="progress">    
		                    <div class="progress-bar progress-bar-lime" style="width: 50%"></div>
		                </div>
		            </div>
		            <div class="mini-progressbar">
		                <div class="clearfix mb-sm">
		                    <div class="pull-left">Storage</div>
		                    <div class="pull-right">25%</div>
		                </div>
		                
		                <div class="progress">    
		                    <div class="progress-bar progress-bar-info" style="width: 25%"></div>
		                </div>
		            </div>

		        </div>
		    </div>
		    <!-- /.end system status -->
    	</div>
    </div>
</div>