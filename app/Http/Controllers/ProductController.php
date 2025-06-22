<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = \App\Models\Product::paginate(12);
        $user = auth()->user();

        if ($user->role === 'super-admin') {
            return view('superadmin.products.index', compact('products'));
        }

        return view('products.index', compact('products'));
    }

    /** GET /superadmin/products */
    public function adminIndex()
    {
        $products = Product::latest()->paginate(20);
        return view('superadmin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ensure destination folder exists
        $folder = public_path('images');
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        // Save the file
        $filename      = uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move($folder, $filename);
        $data['image_path'] = 'images/' . $filename;   

        Product::create($data);

        return redirect()
            ->route('superadmin.products.index')
            ->with('success', 'Product created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(Product $product)
    {
         return view('superadmin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Make image nullable here
        ];

        $data = $request->validate($rules);

        // If a new image is uploaded, process and save it
        if ($request->hasFile('image')) {
            $folder = public_path('images');
            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move($folder, $filename);
            $data['image_path'] = 'images/' . $filename;
        }

        // If no new image uploaded, keep existing image path
        else {
            $data['image_path'] = $product->image_path;
        }

        $product->update($data);

        return redirect()
            ->route('superadmin.products.index')
            ->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        // Delete image file
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
