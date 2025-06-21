<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();   

        switch ($user->role) {
            case 'super-admin':
                return view('dashboards.super_admin');

            case 'admin':
                $orders = \App\Models\Order::with(['user', 'outlet', 'orderItems'])->latest()->get();
                $outlets = \App\Models\Outlet::all();
                return view('dashboards.admin', compact('orders', 'outlets'));

            case 'outlet-in-charge':
                return view('dashboards.outlet');

            case 'user':
                $orders = $user->orders()
                               ->with(['outlet', 'orderItems.product'])
                               ->latest()
                               ->get();
            }

        return view('dashboards.user', compact('orders'));
    }
}
