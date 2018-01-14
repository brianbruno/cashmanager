@extends('layouts.dashboard')

@section('content')
<div id="container">
    <div class="row">
        <div class="col s8">
            <tabela-investimentos></tabela-investimentos>
        </div>
        <div class="col s4">
            <novo-investimento></novo-investimento>
        </div>
    </div>
</div>

@endsection
