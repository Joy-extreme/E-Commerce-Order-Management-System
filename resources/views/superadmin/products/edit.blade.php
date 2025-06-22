@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Product: {{ $product->name }}</h1>

    <form action="{{ route('superadmin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price (Taka) *</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror" required>
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Current Image Path --}}
        <div class="mb-3">
            <label for="current_image" class="form-label">Current Image Path</label>
            <input type="text" id="current_image" class="form-control-plaintext" value="{{ $product->image_path }}" readonly>
        </div>

        {{-- Optional New Image --}}
        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <small class="form-text text-muted">Leave blank to keep the current image.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('superadmin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
