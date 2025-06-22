@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 fw-bold">Super Admin Dashboard</h1>

    @if(session('success'))   {{-- reuse flash success --}}
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        {{-- Products --}}
        <div class="col-md-4">
            <a href="{{ route('superadmin.products.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 hover-lift">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-box-seam display-4"></i>
                        <h5 class="mt-3">Products</h5>
                        <span class="badge bg-primary">{{ $productCount }}</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Users --}}
        <div class="col-md-4">
            <a href="{{ route('superadmin.users.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 hover-lift">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-people display-4"></i>
                        <h5 class="mt-3">Users</h5>
                        <span class="badge bg-primary">{{ $userCount }}</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Orders --}}
        <div class="col-md-4">
            <a href="{{ route('superadmin.outlets.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 hover-lift">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-receipt-cutoff display-4"></i>
                        <h5 class="mt-3">Outlet</h5>
                        <span class="badge bg-primary">{{ $outletCount }}</span>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
