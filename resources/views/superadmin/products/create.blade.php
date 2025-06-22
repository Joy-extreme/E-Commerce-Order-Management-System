@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New Product</h1>

    <form action="{{ route('superadmin.products.index') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (Taka) *</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image *</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required accept="image/*">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create Product</button>
        <a href="{{ route('superadmin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
