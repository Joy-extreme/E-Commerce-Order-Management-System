@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Products</h1>

    <a href="{{ route('superadmin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($products->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th style="width:140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                 
                    <td><img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="60"></td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        <a href="{{ route('superadmin.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('superadmin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    @else
        <p>No products found.</p>
    @endif
</div>
@endsection
