@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h1 class="display-4 fw-bold">Welcome to the Order Management System</h1>
        <p class="lead">Place, track, and manage orders efficiently across multiple outlets.</p>
        @guest
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Get Started</a>
        @endguest
    </div>
</div>
@endsection
