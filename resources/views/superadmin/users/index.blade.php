@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Users</h1>

    <a href="{{ route('superadmin.users.create') }}" class="btn btn-success mb-3">Add New User</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Outlet</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->outlet->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('superadmin.users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
