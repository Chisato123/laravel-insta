<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                      {{-- serchbar --}}
                      @auth <!-- if logged in -->
                      @if(!request()->is('admin/*'))
                      <form action="{{route('index')}}" method="get">
                        {{-- updateやdeleteではないから、getで良い。 --}}
                        <input type="text" name="search" placeholder="Search..." class="form-control form-control-sm">
                      </form>

                      @endif
                      @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        {{-- HOME --}}
                        <li class="nav-item">
                            <a href="{{route('index')}}" class="nav-link">
                                <i class="fa-solid fa-house text-dark icon-sm" ></i>
                            </a>
                        </li>

                        {{-- create post link --}}
                        <li class="nav-item">
                            <a href="{{route('post.create')}}" class="nav-link">
                                <i class="fa-solid fa-circle-plus text-dark icon-sm"></i>
                            </a>
                        </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link btn shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{-- {{ Auth::user()->name }} --}}
                                    {{-- ユーザー名の代わりにアイコン表示 → アイコン写真にupdate --}}
                                @if(Auth::user()->avatar)
                                <img src="{{Auth::user()->avatar}}" alt="" class="rounded-circle avatar-sm">
                                @else
                                <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    {{-- ADMIN --}}
                                    @can('admin')
                                    {{-- adminボタンを顕現がある人だけにしか表示しない。 --}}
                                    <a href="{{route('admin.users')}}" class="dropdown-item">
                                        <i class="fa-solid fa-user-gear"></i> Admin
                                    </a>
                                    <hr class="dropdown-divider">
                                    @endcan
                                    {{-- PROFILE --}}
                                    <a href="{{route('profile.show', Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{-- LOGOUTの加筆部分↓ --}}
                                       <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            {{-- レイアウト調節のため加筆↓ --}}
            <div class="container">
                <div class="row justify-content-center">
                    {{-- admin menu --}}
                    @if(request()->is('admin/*'))
                    <div class="col-3">
                        <div class="list-group">
                            <a href="{{route('admin.users')}}" class="list-group-item {{request()->is('admin/users*') ? 'active' : ''}}">
                                {{-- [if statement] ? [true] : [false] --}}
                                <i class="fa-solid fa-user"></i> Users
                            </a>
                            <a href="{{route('admin.posts')}}" class="list-group-item {{request()->is('admin/posts*') ? 'active' : ''}}">
                                <i class="fa-solid fa-newspaper"></i> Posts
                            </a>
                            <a href="{{route('admin.categories')}}" class="list-group-item {{request()->is('admin/categories*') ? 'active' : ''}}">
                                <i class="fa-solid fa-tags"></i> Categories
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- regular content --}}
                    <div class="col-9">
                        @yield('content')
                    </div>
                </div>
            </div>
            {{-- ↑ --}}
        </main>
    </div>
</body>
</html>
