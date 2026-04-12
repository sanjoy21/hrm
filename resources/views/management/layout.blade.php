<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('management.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('management.dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/rk_logo.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RK HRM</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::guard('management')->user()->image)
                            <img class="img-circle elevation-2"
                                src="{{ asset('storage/' . Auth::guard('management')->user()->image) }}"
                                alt="Profile Picture">
                        @else
                            <img class="img-circle elevation-2" src="{{ asset('dist/img/user.jpg') }}"
                                alt="Default Profile">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('management.profile') }}" class="d-block">{{ Auth::guard('management')->user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('management.dashboard') }}"
                                class="nav-link {{ request()->routeIs('management.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('management.employees') }}"
                                class="nav-link {{ request()->routeIs('management.employees', 'management.employee_profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Employees
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('management/project*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('management/project*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Project Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('management.project_all') }}"
                                        class="nav-link {{ request()->routeIs('management.project_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Project</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('management.project_add') }}"
                                        class="nav-link {{ request()->routeIs('management.project_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Project</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('management.notice_all') }}"
                                class="nav-link {{ request()->routeIs('management.notice_all','management.notice') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Notice
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('management/leave*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('management/leave*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bug"></i>
                                <p>
                                    Apply for Leave
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('management.leave_all') }}"
                                        class="nav-link {{ request()->routeIs('management.leave_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>My Leaves</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('management.leave_application') }}"
                                        class="nav-link {{ request()->routeIs('management.leave_application') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Leave Application</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('management/noc*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('management/noc*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>
                                    Apply for NOC
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('management.noc_all') }}"
                                        class="nav-link {{ request()->routeIs('management.noc_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>My NOC</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('management.noc_application') }}"
                                        class="nav-link {{ request()->routeIs('management.noc_application') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>NOC Application</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('management.logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Log out
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
