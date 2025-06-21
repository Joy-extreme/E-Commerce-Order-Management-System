<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
   
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

   
    public function add(Request $request, Product $product)
    {
        $cart = session('cart', []);

        $cart[$product->id]['name']       = $product->name;
        $cart[$product->id]['price']      = $product->price;
        $cart[$product->id]['image_path'] = $product->image_path;
        $cart[$product->id]['quantity']   = ($cart[$product->id]['quantity'] ?? 0) + 1;

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $qty  = max((int) $request->input('quantity', 1), 0); 
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            if ($qty === 0) {
                unset($cart[$id]);                
            } else {
                $cart[$id]['quantity'] = $qty;    
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')
                         ->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')
                         ->with('success', 'Item removed from cart.');
    }

    
    public function empty()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')
                         ->with('success', 'Cart emptied.');
    }
}
