<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        return view('pages.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stok' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stok = (int) $request->stok;
        $product->category = $request->category;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // $data = $request->all();
        // $product = \App\Models\Product::findOrFail($id);
        // $product->update($data);
        $product = \App\Models\Product::findOrFail($id);
	    $filename=$product->image;
        // check image
       if ($request->hasFile('image')) {
           $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product['image'] = $filename;
       }

        $product->update ([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stok' => (int) $request->stok,
            'category' => $request->category,
            'image' => $filename,

        ]);
        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
