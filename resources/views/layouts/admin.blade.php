<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/adminlte.min.css') }}">
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <style>
        .error {
            color: red;
        }

        .main-sidebar {
            height: 100vh;
            overflow-y: auto;
        }
    </style>
    <title>Add Movie</title>
</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <aside class="col-md-3 col-lg-2 sidebar sidebar-dark bg-dark main-sidebar sidebar-dark-primary elevation-4 d-flex flex-column position-fixed">
                    <div class="position-sticky">
                        <a href="#" class="brand-link" style="text-decoration: none;">
                            <span class="brand-text font-weight-bold text-light text-uppercase">Sumanas Tech</span>
                        </a>
                        <div class="sidebar-nav flex-grow-1">
                            <ul class="nav nav-pills nav-sidebar flex-column flex-column">
                                @if (auth()->user()->role == 'admin')
                                <li class="nav-item">
                                    <a href="{{route('admin.index')}}" class="nav-link" name="logout">
                                        <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                                        <p>All Quiz List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" name="logout">
                                        <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                                        <p>User Page</p>
                                    </a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="{{route('logout')}}" class="nav-link" name="logout">
                                        <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                                        <p>Log out</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="{{ asset('/assets/plugins/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('/assets/js/adminlte.js') }}"></script>
</body>
</html>
