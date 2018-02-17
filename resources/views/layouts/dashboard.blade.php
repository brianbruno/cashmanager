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
    <link href="https://fonts.googleapis.com/css?family=Shanti" rel="stylesheet">

    <style>
        #saldo-btc {
            font-family: 'Shanti', sans-serif;
        }
    </style>


</head>
<body class="blue-grey lighten-5">
    <div id="app">
        <header>
            <div class="container"><a href="#" data-target="slide-out" class="top-nav sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a></div>

            <ul id="slide-out" class="sidenav sidenav-fixed blue-grey darken-4">
                <li class="logo center">
                    <a id="logo-container" href="/" class="brand-logo white-text"><h5 class="tituloNavBar">CashManager</h5></a>
                </li>
                @if (MinhaContaController::showSaldoOnMenu() == 'S')
                <div class="card grey darken-4 hoverable">
                    <div class="card-content">
                        <div class="col s12 valign-wrapper">
                            <span class="green-text"><i class="material-icons small">attach_money</i></span> <span id="saldo-btc" class="white-text flow-text">{{ ContaController::getSaldo() }}</span>
                        </div>
                    </div>
                </div>
                @endif
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li><a class="collapsible-header waves-effect waves-blue-grey white-text itemNavBar"><h5>Contas</h5></a>
                            <div class="collapsible-body blue-grey darken-3">
                                <ul>
                                    <li><a class="white-text" href="{{ route('abrir-conta') }}">Abrir/Fechar conta</a></li>
                                    <li><a class="white-text" href="{{ route('extrato-contas') }}">Extrato</a></li>
                                    <li><a class="white-text" href="{{ route('abrir-conta') }}">Excluir conta</a></li>
                                    <li><a class="white-text" href="{{ route('contas') }}">Nova movimentação</a></li>
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
                        <li>
                            <a class="collapsible-header waves-effect waves-blue-grey white-text itemNavBar"><h5>Niquelino Bot</h5></a>
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
            <div class="navbar-fixed hide-on-med-and-down">
                <nav>
                    <div class="nav-wrapper blue-grey lighten-5">
                        <div class="row">
                            <div class="col m8 l8 hide-on-med-and-down">
                                <valores-mercado></valores-mercado>
                            </div>
                            <div class="col s12 m4 l4" id="controle-conta">
                                <span id="nome-cliente"><a class="black-text" href="{{ route('minha-conta') }}">{{ Auth::user()->name }}</a></span>

                                <a href="{{ route('logout') }}" class="btn red darken-4 waves-effect waves-red white-text" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" id="btn-sair">Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                                    {{ csrf_field() }}
                                </form>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.3/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".dropdown-trigger").dropdown();
            $('.sidenav').sidenav();
            $('.collapsible').collapsible();
        });
    </script>
</body>
</html>
