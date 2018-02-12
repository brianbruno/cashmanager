@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col s12">
        @if (MinhaContaController::niquelinoAtivo() == 'S')
            <niquelino-dashboard></niquelino-dashboard>
        @else
        <div class="col s12">
            <div class="col s12">
                <div class="card orange lighten-5 z-depth-2">
                    <div class="card-content">
                        <div class="center-align">
                            <div id="exibirLucro">
                                <div id="lucroContas" class="center-align">
                                    <h4 class="black-text">Niquelino Bot não está ativo na sua conta.</h4>
                                    <h6 class="black-text">Para ativá-lo <a href="{{ route('minha-conta') }}">clique aqui</a>.</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
