<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminLTE 3 | Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- all CSS -->
    <link rel="stylesheet" href="css/app.css">
</head>
<body class="hold-transition sidebar-mini" >
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{url('/')}}" class="nav-link">Home</a>
            </li>

        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </nav>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="img/logo.jpg" alt="Vue Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Vue Project</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img/profile/{{auth()->user()->photo}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="/profile" class="d-block">{{auth()->user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt text-indigo"></i>
                            <p>
                                Dashboard
                            </p>
                        </router-link>
                    </li>

                    <!-- can is used for Gate protection SO IMPORTANT-->
                    @can('isAdmin')
                            <li class="nav-item">
                                <router-link to="/user" class="nav-link ">
                                    <i class="fas fa-users nav-icon text-green"></i>
                                    <p>Users Page</p>
                                </router-link>
                            </li>
                    <li class="nav-item">
                        <router-link to="/developer" class="nav-link">
                            <i class="nav-icon fas fa-cog"  ></i>
                            <p>
                                Developer
                            </p>
                        </router-link>
                    </li>
                        <li class="nav-item">
                            <router-link to="/governorate" class="nav-link">
                                <i class="nav-icon fas fa-cog"  ></i>
                                <p>
                                    Governorates
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/city" class="nav-link">
                                <i class="nav-icon fas fa-cog" ></i>
                                <p>
                                    Cities
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/product" class="nav-link">
                                <i class="nav-icon fas fa-cog" ></i>
                                <p>
                                    Products
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/orders" class="nav-link">
                                <i class="nav-icon fas fa-cog" ></i>
                                <p>
                                    Orders
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/category" class="nav-link">
                                <i class="nav-icon fas fa-cog" ></i>
                                <p>
                                    Categories
                                </p>
                            </router-link>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fas fa-user text-red" ></i>
                            <p>
                                Profile
                            </p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content" style="overflow:hidden;">
            <!-- component matched by the route will render here -->
            <router-view>

            </router-view>
            <!-- Vue progress bar package-->
            <vue-progress-bar>
            </vue-progress-bar>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->
@auth()
    <!--THIS BELONG TO Gate in app.js  -->
   <script>
       window.user = @json(Auth()->user());
   </script>
    @endauth

<!-- REQUIRED SCRIPTS -->

<script src="js/app.js"></script>
</body>
</html>
