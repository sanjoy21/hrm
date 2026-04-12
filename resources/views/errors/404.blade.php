@extends(
    Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'admin'
        ? 'admin.index'
        : (Auth::guard('management')->check() && Auth::guard('management')->user()->role === 'management'
            ? 'management.index'
            : (Auth::guard('army')->check() && Auth::guard('army')->user()->role === 'army'
                ? 'army.index'
                : (Auth::check() && Auth::user()->role === 'employee'
                    ? 'employee.index'
                    : null ))) {{-- fallback layout for guests --}}
)

@section('title')
    Page Not Found
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Page Not Found</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                @if(Auth::guard('admin')->check())
                                    <a href="{{ route('admin.dashboard') }}">Home</a>
                                @elseif(Auth::guard('management')->check())
                                    <a href="{{ route('management.dashboard') }}">Home</a>
                                @elseif(Auth::check() && Auth::user()->role === 'employee')
                                    <a href="{{ route('employee.dashboard') }}">Home</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active">Page Not Found</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning">404</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may
                        @if(Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}">return to dashboard</a>
                        @elseif(Auth::guard('management')->check())
                            <a href="{{ route('management.dashboard') }}">return to dashboard</a>
                        @elseif(Auth::check() && Auth::user()->role === 'employee')
                            <a href="{{ route('employee.dashboard') }}">return to dashboard</a>
                        @endif
                        or try using the search form.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
