@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                  
                    <h1>
                       Bem vindo, {{ Auth::user()->name }}!
                    </h1> 
                      <dashboard></dashboard>
                    
                      <div class="row">
                      <div class="col s12">
                        <div class="card-panel blue lighten-5">
                          <span class="black-text">
                            @if (!$investimentosHoje)
                              Parabéns! Seu investimento hoje deu um lucro de R$ 0,25.
                            @else
                              Você não investiu hoje. O que está esperando
                            @endif
                          </span>
                        </div>
                      </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
