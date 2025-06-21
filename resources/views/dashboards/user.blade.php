@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Your Orders</h1>

    {{-- 🔗 1-click link to the product catalogue --}}
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">
        <i class="bi bi-box-seam me-1"></i> Browse Products
    </a>

    @if($orders->isEmpty())
        {{-- Encourage first-time shoppers --}}
        <p>You haven’t placed any orders yet. Click the button above to start shopping!</p>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Outlet</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Placed&nbsp;At</th>
                    <th>Items</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->outlet->name ?? '—' }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            ৳ {{ number_format(
                                $order->orderItems->sum(function ($item) {
                                    return $item->price * $item->quantity;
                                }),
                                2
                            ) }}
                        </td>
                        <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach($order->orderItems as $item)
                                    <li>{{ $item->product->name ?? 'Deleted' }} × {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
