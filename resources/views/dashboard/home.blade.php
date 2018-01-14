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
                    <div class="row">
                        <h5>
                            Bem vindo, {{ Auth::user()->name }}!
                        </h5>
                        <div class="col s12">
                            <dashboard></dashboard>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
