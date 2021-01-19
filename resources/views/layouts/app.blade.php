<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- all CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <!-- Fonts
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
         i dont know what is this used for ..-->
    </head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <?php
                        $path=Request::path()
                        ?>
                        <li class="{{$path==='/'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{url('/')}}">Home
                            </a>
                        </li>
                        <li class="{{$path==='products'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{url('/products')}}">Products</a>
                        </li>
                        <li class="{{$path==='posts'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{url('/posts')}}">Posts</a>
                        </li>
                        <li class="{{$path==='chat'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{url('/chat')}}">Chat</a>
                        </li>
                        <li class="{{$path==='questionnaire'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{route('questionnaire.index')}}">Create Survey</a>
                        </li>
                        <li class="{{$path==='todo'?'nav-item active':'nav-item'}}">
                            <a class="nav-link" href="{{route('todo')}}">TODO App</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <!--notification bell component  -->
                        @auth()
                        <notify-bill></notify-bill>
                        @endauth
                        <!--cart icon component  -->
                        <nav-bar-cart></nav-bar-cart>
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
                        <!--User Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="margin-top: 9px">
                                    <a href="{{url('order')}}" class="dropdown-item" style="font-size: 18px">
                                        <i class="fas fa-store"></i> &nbsp; Orders
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="btn btn-success" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="margin-left: 40px; margin-top: 10px;">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('sweetalert::alert')
    @yield('scripts')
</body>
<!-- stripe payment -->
<script src="https://js.stripe.com/v3/"></script>

</html>
