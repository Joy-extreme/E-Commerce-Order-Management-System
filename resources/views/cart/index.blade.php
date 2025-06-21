@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Your Cart</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php
                        $subtotal = $details['price'] * $details['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <img src="{{ asset($details['image_path']) }}" width="50" alt="{{ $details['name'] }}">
                            {{ $details['name'] }}
                        </td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control me-2" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>৳ {{ number_format($details['price'], 2) }}</td>
                        <td>৳ {{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td>৳ {{ number_format($total, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- Checkout form (separate, not wrapping other forms) --}}
        <form method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <div class="mb-3">
                <label for="outlet_id" class="form-label">Select Outlet</label>
                <select name="outlet_id" id="outlet_id" class="form-select" required>
                    <option value="" disabled selected>Select Outlet</option>
                    @foreach(\App\Models\Outlet::all() as $outlet)
                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>

        {{-- Empty Cart Button --}}
        <form method="POST" action="{{ route('cart.empty') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Empty Cart</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
