<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #3C5B6F;">
    <!-- Brand Logo -->
    <div class="brand-link" style="display: flex; align-items: center; padding: 10px;">
        <img src="https://content.jdmagicbox.com/comp/navi-mumbai/f1/022pxx22.xx22.180215143800.m6f1/catalogue/food-junction-kopar-khairane-navi-mumbai-home-delivery-restaurants-8tnfw.jpg"
            alt="Restaurant Logo" style="width:60px;">
        <span style="color: white; font-size: 24px; margin-left: 10px;">Food Junction</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashbord') }}"
                        class="nav-link {{ request()->is('admin/dashbord') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.restaurant.list') }}"
                        class="nav-link {{ request()->routeIs('admin.restaurant*') ? 'active' : '' }}">
                        <i class="fa fa-home nav-icon"></i>
                        <p style="color:white">Restaurant Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.list') }}"
                        class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fa fa-database nav-icon"></i>
                        <p style="color:white">Category</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.allrestaurants.list') }}"
                        class="nav-link {{ request()->routeIs('admin.allrestaurants*')||request()->routeIs('admin.menuofrestaurants*') ? 'active' : '' }}">
                        <i class="fa fa-cutlery nav-icon"></i>
                        <p style="color:white">Restaurants</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.offersofrestaurants.list') }}"
                        class="nav-link {{ request()->routeIs('admin.offersofrestaurants*') ? 'active' : '' }}">
                        <i class="fas fa-gift nav-icon"></i>
                        <p style="color:white">Offer</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.calendar.calendar') }}"
                        class="nav-link {{ request()->routeIs('admin.calendar*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p style="color:white">Event Calendar</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" id="settings-link">
                        <i class="fa fa-cogs nav-icon"></i>
                        <p style="color:white">Settings<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview" id="settings-menu">
                        <li class="nav-item">
                            <a href="{{ url('permission') }}" class="nav-link {{ request()->is('permission') ? 'active' : '' }}">
                                <i class="fa fa-lock nav-icon"></i>
                                <p style="color:white">Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('role') }}" class="nav-link {{ request()->is('role') ? 'active' : '' }}">
                                <i class="fa fa-users nav-icon"></i>
                                <p style="color:white">Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p style="color:white">User</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                @can('view setting')
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
                        id="settings-link">
                        <i class="fa fa-cogs nav-icon"></i>
                        <p style="color:white">Settings<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview" id="settings-menu"
                        style="{{ request()->routeIs('permission*') || request()->routeIs('role*') || request()->routeIs('users*') ? 'display: block;' : 'display: none;' }}">
                        <li class="nav-item">
                            <a href="{{ url('permission') }}"
                                class="nav-link {{ request()->routeIs('permission*') ? 'active' : '' }}">
                                <i class="fa fa-lock nav-icon"></i>
                                <p style="color:white">Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('role') }}" class="nav-link {{ request()->routeIs('role*') ? 'active' : '' }}">
                                <i class="fa fa-users nav-icon"></i>
                                <p style="color:white">Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p style="color:white">User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>