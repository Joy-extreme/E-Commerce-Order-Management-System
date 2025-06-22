<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::with('outlet')->latest()->paginate(20);

        return view('superadmin.users.index', compact('users'));
    }

   
    public function create()
    {
        $outlets = Outlet::all();
        return view('superadmin.users.create', compact('outlets'));
    }

   
    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',     
            'role'     => 'required|in:admin,outlet_in_charge',
        ];

       
        if ($request->role === 'outlet_in_charge') {
            $rules['outlet_id'] = 'required|exists:outlets,id';
        }

        $data              = $request->validate($rules);
        $data['password']  = Hash::make($data['password']);

        if ($data['role'] !== 'outlet_in_charge') {
            $data['outlet_id'] = null;
        }

        User::create($data);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User created.');
    }

  
    public function edit(User $user)
    {
        $outlets = Outlet::all();
        return view('superadmin.users.edit', compact('user', 'outlets'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,outlet_in_charge',
            'password' => 'nullable|min:6|confirmed',
        ];

        if ($request->role === 'outlet_in_charge') {
            $rules['outlet_id'] = 'required|exists:outlets,id';
        }

        $data = $request->validate($rules);

        // hash new password only if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // clear outlet_id if role isn't outlet_in_charge
        if ($data['role'] !== 'outlet_in_charge') {
            $data['outlet_id'] = null;
        }

        $user->update($data);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
