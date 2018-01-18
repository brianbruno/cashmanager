<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cash Manager') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hover.css') }}" rel="stylesheet">
  
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div id="app">

        <ul id="dropdownUser" class="dropdown-content">
            <li><a href="{{ route('minha-conta') }}">Minha Conta</a></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>

        <nav>
            <div class="nav-wrapper teal darken-4">
                <a class="brand-logo" href="{{ url('/') }}">CashManager</a>
                <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{ route('contas') }}">Contas</a></li>
                    <li><a href="{{ route('investimentos') }}">Investimentos</a></li>
                    <li><a class="dropdown-trigger" href="#!" data-target="dropdownUser">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
                <ul class="sidenav" id="mobile-nav">
                    <li><a href="{{ route('contas') }}">Contas</a></li>
                    <li><a href="{{ route('investimentos') }}">Investimentos</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type = "text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.2/js/materialize.min.js"></script>
    <script>

        $(document).ready(function() {
            $(".dropdown-trigger").dropdown();
            $('.sidenav').sidenav();
        });

    </script>
</body>
</html>
