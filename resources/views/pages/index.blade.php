@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>Awesome simple blog</p>
        @if (Auth::guest())
        <p>
            <a href="login" class="btn btn-success btn-lg">Login</a>
            <a href="register" class="btn btn-primary btn-lg">Register</a>
        </p>
        @endif
    </div>    
@endsection
