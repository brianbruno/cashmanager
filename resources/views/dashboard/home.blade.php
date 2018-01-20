@extends('layouts.dashboard')

@section('content')
<div id="homePage">
    <div class="row">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="col s12">
            <dashboard></dashboard>
        </div>
    </div>
</div>
@endsection
