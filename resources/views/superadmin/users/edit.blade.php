@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit User: {{ $user->name }}</h1>

    <form action="{{ route('superadmin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="form-control @error('name') is-invalid @enderror"
                   required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- (Optional) Reset password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank to keep current)</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label for="role" class="form-label">Role *</label>
            <select id="role"
                    name="role"
                    class="form-select @error('role') is-invalid @enderror"
                    required
                    onchange="toggleOutletField()">
                <option value="">Select Role</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="outlet_in_charge" {{ old('role', $user->role) == 'outlet_in_charge' ? 'selected' : '' }}>Outlet In Charge</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Outlet picker (hidden unless outlet_in_charge) --}}
        <div class="mb-3" id="outletField" style="display:none;">
            <label for="outlet_id" class="form-label">Outlet *</label>
            <select id="outlet_id"
                    name="outlet_id"
                    class="form-select @error('outlet_id') is-invalid @enderror">
                <option value="">Select Outlet</option>
                @foreach($outlets as $outlet)
                    <option value="{{ $outlet->id }}"
                        {{ old('outlet_id', $user->outlet_id) == $outlet->id ? 'selected' : '' }}>
                        {{ $outlet->name }}
                    </option>
                @endforeach
            </select>
            @error('outlet_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Update User</button>
        <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
function toggleOutletField() {
    const role   = document.getElementById('role').value;
    const outlet = document.getElementById('outletField');
    outlet.style.display = role === 'outlet_in_charge' ? 'block' : 'none';
}
toggleOutletField(); // run on first load
</script>
@endsection
