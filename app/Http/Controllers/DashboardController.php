<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Outlet;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();   

        switch ($user->role) {
            case 'super-admin':
                case 'super-admin':
                $productCount = Product::count();
                $userCount = User::count();
                $outletCount = Outlet::count();

                return view('dashboards.super_admin', compact('productCount', 'userCount',  'outletCount'));
            case 'admin':
                $orders = \App\Models\Order::with(['user', 'outlet', 'orderItems'])->latest()->get();
                $outlets = \App\Models\Outlet::all();
                return view('dashboards.admin', compact('orders', 'outlets'));

            case 'outlet-in-charge':
                $managedOutletId = $user->outlet_id;
                $orders = \App\Models\Order::with(['user', 'outlet', 'orderItems'])
                            ->where('outlet_id', $managedOutletId)
                            ->latest()
                            ->get();

                $outlets = \App\Models\Outlet::where('id', '<>', $managedOutletId)->get();

                return view('dashboards.outlet_in_charge', compact('orders', 'outlets'));

            case 'user':
                $orders = $user->orders()
                               ->with(['outlet', 'orderItems.product'])
                               ->latest()
                               ->get();
            }

        return view('dashboards.user', compact('orders'));
    }
}
