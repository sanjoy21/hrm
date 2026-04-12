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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
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
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <img src="{{ asset('dist/img/rk_logo.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RK HRM</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::guard('admin')->user()->image)
                            <img class="img-circle elevation-2"
                                src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}"
                                alt="Profile Picture">
                        @else
                            <img class="img-circle elevation-2" src="{{ asset('dist/img/user.jpg') }}"
                                alt="Default Profile">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('admin.profile') }}"
                            class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
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
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('appointment_letter*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('appointment_letter*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>
                                    Appointment Letter
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('appointment_letter_all') }}"
                                        class="nav-link {{ request()->routeIs('appointment_letter_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Appointment Letter</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('appointment_letter_add') }}"
                                        class="nav-link {{ request()->routeIs('appointment_letter_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Appointment Letter</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('employee*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('employee*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Employee
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('all.employee') }}"
                                        class="nav-link {{ request()->routeIs('all.employee') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Employee</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('add.employee') }}"
                                        class="nav-link {{ request()->routeIs('add.employee') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Employee</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('office') }}"
                                class="nav-link {{ request()->routeIs('office', 'edit_office') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>
                                    Office
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('departments') }}"
                                class="nav-link {{ request()->routeIs('departments', 'edit_department') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Departments
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('salary_structure*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('salary_structure*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill-wave"></i>
                                <p>
                                    Salary Structure
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('salary_structure_view') }}"
                                        class="nav-link {{ request()->routeIs('salary_structure_view') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>View Salary Structure</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('salary_structure') }}"
                                        class="nav-link {{ request()->routeIs('salary_structure') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Salary Structure</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('leave_all', 'leave_application') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('leave_all', 'leave_application') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bug"></i>
                                <p>
                                    Apply for Leave
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('leave_all') }}"
                                        class="nav-link {{ request()->routeIs('leave_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>My Leaves</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('leave_application') }}"
                                        class="nav-link {{ request()->routeIs('leave_application') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Leave Application</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('apply_for_noc', 'my_noc_list','my_noc*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('apply_for_noc', 'my_noc_list','my_noc*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>
                                    Apply for NOC
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('my_noc_list') }}"
                                        class="nav-link {{ request()->routeIs('my_noc_list') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>My NOC</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('apply_for_noc') }}"
                                        class="nav-link {{ request()->routeIs('apply_for_noc') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>NOC Application</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('attendance') }}"
                                class="nav-link {{ request()->routeIs('attendance') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Daily Attendance
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('attendance_report') }}"
                                class="nav-link {{ request()->routeIs('attendance_report') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Attendance Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('initial_salary_sheet') }}"
                                class="nav-link {{ request()->routeIs('initial_salary_sheet') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    Initial Salary Sheet
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('salary_sheet*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('salary_sheet*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-check"></i>
                                <p>
                                    Salary Sheet
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('salary_sheet_view') }}"
                                        class="nav-link {{ request()->routeIs('salary_sheet_view') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>View Salary Sheet</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('salary_sheet_add') }}"
                                        class="nav-link {{ request()->routeIs('salary_sheet_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Salary Sheet</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('promotion*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('promotion*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-award"></i>
                                <p>
                                    Promotion
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('promotion_all') }}"
                                        class="nav-link {{ request()->routeIs('promotion_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Promotion History</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('promotion') }}"
                                        class="nav-link {{ request()->routeIs('promotion') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Promotion</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        {{-- <li class="nav-item {{ request()->is('project*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('project*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Project Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('project_all') }}"
                                        class="nav-link {{ request()->routeIs('project_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Project</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('project_add') }}"
                                        class="nav-link {{ request()->routeIs('project_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Project</p>
                                    </a>
                                </li>

                            </ul>
                        </li> --}}

                        <li class="nav-item {{ request()->is('project*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('project*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Project Management
                                    @php
                                        // Get unread comments count for admin (from employees)
                                        $unreadComments = \App\Models\ProjectComment::where('user_role', 'employee')
                                            ->where('is_read', false)
                                            ->count();
                                    @endphp
                                    @if ($unreadComments > 0)
                                        <span class="right badge badge-danger">{{ $unreadComments }}</span>
                                    @endif
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('project_all') }}"
                                        class="nav-link {{ request()->routeIs('project_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Project</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('project_add') }}"
                                        class="nav-link {{ request()->routeIs('project_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Project</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('application_all') }}"
                                class="nav-link {{ request()->routeIs('application_all', 'application') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Application
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('manual_leave_approval') }}"
                                class="nav-link {{ request()->routeIs('manual_leave_approval') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Manual Leave Approval
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('leave_type') }}"
                                class="nav-link {{ request()->routeIs('leave_type', 'leave_type_edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bug"></i>
                                <p>
                                    Leave Type
                                </p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('noc*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('noc*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>
                                    NOC
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('noc_type') }}"
                                        class="nav-link {{ request()->routeIs('noc_type', 'noc_type_edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>NOC Type</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('noc_all') }}"
                                        class="nav-link {{ request()->routeIs('noc_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All NOC</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('noc_add') }}"
                                        class="nav-link {{ request()->routeIs('noc_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add NOC</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('noc_application_all') }}"
                                        class="nav-link {{ request()->routeIs('noc_application_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>NOC Application</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('notice*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('notice*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>
                                    Notice
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('notice_all') }}"
                                        class="nav-link {{ request()->routeIs('notice_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Notice</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('notice_add') }}"
                                        class="nav-link {{ request()->routeIs('notice_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Notice</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('warning*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('warning*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-skull-crossbones"></i>
                                <p>
                                    Warning
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('warning_all') }}"
                                        class="nav-link {{ request()->routeIs('warning_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Warning</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('warning_add') }}"
                                        class="nav-link {{ request()->routeIs('warning_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Warning</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item {{ request()->is('resign*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('resign*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake-slash"></i>
                                <p>
                                    Resign
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('resign_all') }}"
                                        class="nav-link {{ request()->routeIs('resign_all') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Resign</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('resign_add') }}"
                                        class="nav-link {{ request()->routeIs('resign_add') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Resign</p>
                                    </a>
                                </li>

                            </ul>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
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
