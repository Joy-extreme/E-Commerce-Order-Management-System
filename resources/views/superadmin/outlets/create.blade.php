@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Outlet</h1>

    <form action="{{ route('superadmin.outlets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Outlet Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location *</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" required>
            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create Outlet</button>
        <a href="{{ route('superadmin.outlets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
