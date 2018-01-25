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
<body class="blue-grey lighten-5">
    <div id="app">
        <header>
            <div class="container"><a href="#" data-target="slide-out" class="top-nav sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a></div>
            <ul id="slide-out" class="sidenav sidenav-fixed blue-grey darken-3">
                <li class="logo center">
                    <a id="logo-container" href="/" class="brand-logo white-text"><h4 class="tituloNavBar">CashManager</h4></a>
                </li>

                <div class="card blue-grey darken-4 hoverable">
                    <div class="card-content">
                        <div class="col s12">
                            <i class="material-icons medium left white-text">account_box</i>
                            <a href="{{ route('logout') }}" class="btn-flat waves-effect waves-red right red-text bold" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="col s12">
                            <span class="title"><a class="white-text" href="{{ route('minha-conta') }}">{{ Auth::user()->name }}</a></span>

                            <p class="white-text">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li><a class="collapsible-header waves-effect waves-blue-grey white-text itemNavBar"><h5>Contas</h5></a>
                            <div class="collapsible-body blue-grey darken-3">
                                <ul>
                                    <li><a class="white-text" href="{{ route('abrir-conta') }}">Abrir/Fechar conta</a></li>
                                    <li><a class="white-text" href="{{ route('extrato-contas') }}">Extrato</a></li>
                                    <li><a class="white-text" href="{{ route('abrir-conta') }}">Excluir conta</a></li>
                                    <li><a class="white-text" href="{{ route('contas') }}">Registrar movimentação</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header waves-effect waves-blue-grey white-text itemNavBar"><h5>Investimentos</h5></a>
                            <div class="collapsible-body blue-grey darken-3">
                                <ul>
                                    <li><a class="white-text" href="{{ route('investimentos') }}">Investir</a></li>
                                    <li><a class="white-text" href="{{ route('investimentos') }}">Investimentos Ativos</a></li>
                                    <li><a class="white-text" href="{{ route('relatorios') }}">Relatórios</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header waves-effect waves-blue-grey white-text itemNavBar"><h5>Niquelino Bot</h5></a>
                            <div class="collapsible-body blue-grey darken-3">
                                <ul>
                                    <li><a class="white-text" href="{{ route('niquelino.dashboard') }}">Dashboard</a></li>
                                    <li><a class="white-text" href="{{ route('niquelino.configuracoes') }}">Configurações</a></li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </li>
            </ul>
        </header>
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type = "text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.2/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".dropdown-trigger").dropdown();
            $('.sidenav').sidenav();
            $('.collapsible').collapsible();
        });

    </script>
</body>
</html>
