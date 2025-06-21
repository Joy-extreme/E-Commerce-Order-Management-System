@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Admin Dashboard – Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>No orders found.</p>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Outlet</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Placed At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '—' }}</td>
                    <td>{{ $order->outlet->name ?? '—' }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        ৳ {{ number_format(
                              $order->orderItems->sum(function ($item) {
                                  return $item->price * $item->quantity;
                              }),
                              2)
                          }}
                    </td>
                    <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
                    <td>
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('admin.orders.accept', $order->id) }}" class="d-inline me-1">
                                @csrf
                                <button class="btn btn-sm btn-success">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                        @elseif($order->status === 'accepted')
                            <form method="POST" action="{{ route('admin.orders.transfer', $order->id) }}" class="d-flex gap-2">
                                @csrf
                                <select name="outlet_id" required class="form-select form-select-sm w-auto">
                                    @foreach($outlets as $outlet)
                                        <option value="{{ $outlet->id }}" {{ $order->outlet_id == $outlet->id ? 'selected' : '' }}>
                                            {{ $outlet->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-warning">Transfer</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
