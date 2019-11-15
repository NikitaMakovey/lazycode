<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lazycode') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
</head>
<body>
    <div id="app">
        <nav class="lazycode-navbar navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand logo-link" href="{{ url('/') }}">
                    {{ config('app.name', 'Lazycode') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <button type="submit" class="btn logo-button">
                                    <a class="nav-link logo-link"
                                       href="{{ route('login') }}">
                                        {{ __('Войти') }}
                                    </a>
                                </button>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <button type="submit" class="btn logo-button">
                                        <a class="nav-link logo-link"
                                           href="{{ route('register') }}">
                                            {{ __('Зарегистрироваться') }}
                                        </a>
                                    </button>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <button type="submit" class="btn logo-button">
                                    <router-link to="/posts/create" class="nav-link logo-link">{{ __('Запостить') }}</router-link>
                                </button>
                            </li>
                            <li class="nav-item dropdown">
                                <button type="submit" class="btn logo-button">
                                    <a id="navbarDropdown" class="logo-link nav-link dropdown-toggle"
                                        href="{{ route('users.show', Auth::user()->username) }}"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->username }}
                                        <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Выйти') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </button>

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
</body>
</html>
