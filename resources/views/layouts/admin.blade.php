<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">
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
                <aside class="col-md-3 col-lg-2 sidebar-dark bg-dark main-sidebar sidebar-primary elevation-4 d-flex flex-column position-fixed">
                    <a href="index3.html" class="brand-link">
                      <img src="{{asset('assets/images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                      <span class="brand-text font-weight-light text-uppercase text-decoration-none">Sumanas Tech.</span>
                    </a>
        
                    <div class="sidebar">
                      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                          <img src="{{asset('assets/images/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                          <a href="#" class="d-block fs-5 text-uppercase text-decoration-none">{{Auth::user()->name}}</a>
                        </div>
                      </div>
                      
                      <!-- Sidebar Menu -->
                      <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                          <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>Dashboard</p>
                            </a>
                            <ul class="nav nav-treeview">
                            @if(Auth::user()->role == 'admin')
                              <li class="nav-item">
                                <a href="{{route('home')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>USER PAGE</p>
                                </a>
                              </li>
                            @endif
                            </ul>
                          </li>
                          <li class="nav-item menu-open">
                            <a href="{{route('logout.user')}}" class="nav-link">
                              <i class="fas fa-sign-out-alt"></i>
                              <p>Log out</p>
                            </a>
                        </li>
                        </ul>
                      </nav>
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
