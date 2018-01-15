@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <h5>
            Bem vindo, {{ Auth::user()->name }}!
        </h5>
        <div class="col s12">
            <dashboard></dashboard>
        </div>
    </div>
</div>
@endsection
