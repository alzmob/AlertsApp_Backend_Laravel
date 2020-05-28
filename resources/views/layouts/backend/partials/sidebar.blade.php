<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->getFirstMediaUrl('avatar') != null ? auth()->user()->getFirstMediaUrl('avatar') : config('app.placeholder').'160' }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::User()->first_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('app.dashboard') }}"
                        class="nav-link {{ Route::is('app.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('app.cities.index') }}"
                        class="nav-link {{ Request::is('app/cities*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-city"></i>
                        <p>
                            Cities
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('app.alerts.index') }}"
                        class="nav-link {{ Request::is('app/alerts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Alerts
                        </p>
                    </a>
                </li>

                <li
                    class="nav-item has-treeview {{ Request::is('app/permissions*','app/roles*','app/users*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('app/permissions*','app/roles*','app/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-fingerprint"></i>
                        <p>
                            Access Control
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('app.permissions.index') }}"
                                class="nav-link {{ Request::is('app/permissions*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-universal-access"></i>
                                <p>
                                    Permissions
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('app.roles.index') }}"
                                class="nav-link {{ Request::is('app/roles*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-secret"></i>
                                <p>
                                    Roles
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('app.users.index') }}"
                                class="nav-link {{ Request::is('app/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
