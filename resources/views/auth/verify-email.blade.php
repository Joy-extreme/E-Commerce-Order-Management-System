@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Verify Your Email Address</h2>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <p>
        Before proceeding, please check your email for a verification link.
        verify your email to log into the system,
    </p>

</div>
@endsection
