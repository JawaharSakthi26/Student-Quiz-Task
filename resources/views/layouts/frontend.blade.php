<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/adminlte.min.css') }}">
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="preloader flex-column justify-content-center align-items-center bg-dark">
            <img class="animation__wobble" src="{{asset('assets/images/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
        </div>

         <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout.user') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout.user') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
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
                    <a href="{{route('home')}}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>
                    </a>
                    <ul class="nav nav-treeview">
                    @if(Auth::user()->role == 'admin')
                      <li class="nav-item">
                        <a href="{{route('admin.home')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>ADMIN PAGE</p>
                        </a>
                      </li>
                    @endif
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
        </aside>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('/assets/js/adminlte.js') }}"></script>
</body>
</html>
