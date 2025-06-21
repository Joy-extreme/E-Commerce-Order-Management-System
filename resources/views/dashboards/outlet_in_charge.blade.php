@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Outlet In Charge Dashboard – My Outlet Orders</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>No orders found for your outlet.</p>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
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
                            <form method="POST" action="{{ route('outlet.orders.accept', $order->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('outlet.orders.cancel', $order->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                        @endif

                        @if($order->status === 'accepted')
                            <form method="POST" action="{{ route('outlet.orders.transfer', $order->id) }}" class="d-inline">
                                @csrf
                                <select name="outlet_id" required class="form-select d-inline w-auto">
                                    @foreach($outlets as $outlet)
                                        @if($outlet->id !== auth()->user()->outlet_id)
                                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                        @endif
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
