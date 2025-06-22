@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Outlets</h1>

    <a href="{{ route('superadmin.outlets.create') }}" class="btn btn-success mb-3">Add New Outlet</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($outlets as $outlet)
                <tr>
                    <td>{{ $outlet->name }}</td>
                    <td>{{ $outlet->location }}</td>
                    <td>
                        <a href="{{ route('superadmin.outlets.edit', $outlet) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('superadmin.outlets.destroy', $outlet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this outlet?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No outlets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
