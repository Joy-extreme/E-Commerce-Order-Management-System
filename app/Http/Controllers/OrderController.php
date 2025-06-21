<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;     
use App\Models\Outlet;    

class OrderController extends Controller
{
    public function index()
    {
        
        $orders  = Order::with(['user', 'outlet', 'orderItems'])->latest()->get();
        $outlets = Outlet::all();   

        return view('admin.orders.index', compact('orders', 'outlets'));
    }
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $qty = $request->input('quantity', 1);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $qty,
                "price" => $product->price,
                "image_path" => $product->image_path,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $quantity = $request->input('quantity');
            if($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.view')->with('success', 'Cart updated successfully.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.view')->with('success', 'Item removed from cart.');
    }

    public function emptyCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.view')->with('success', 'Cart emptied.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
        ]);

        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect()->route('cart.view')->with('success', 'Cart is empty.');
        }

        
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'outlet_id' => $request->outlet_id,
            'status' => 'pending',
        ]);

       
        foreach($cart as $productId => $details) {
            $order->orderItems()->create([
                'product_id' => $productId,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }
    public function accept(Order $order)
    {
        $order->status = 'accepted';
        $order->save();

        return back()->with('status', 'Order accepted.');
    }

    public function cancel(Order $order)
    {
        $order->status = 'cancelled';
        $order->save();

        return back()->with('status', 'Order cancelled.');
    }

    public function transfer(Request $request, Order $order)
    {
        $request->validate(['outlet_id' => 'required|exists:outlets,id']);

        if ($order->outlet_id == $request->outlet_id) {
            return back()->with('error', 'Order is already at this outlet.');
        }

        $order->outlet_id = $request->outlet_id;
        $order->save();

        return back()->with('success', 'Order transferred.');
    }


}
