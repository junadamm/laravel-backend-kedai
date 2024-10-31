<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        // Simpan gambar ke storage/app/public/images
        $request->image->storeAs('public/images', $imageName);

        // Simpan nama gambar ke database atau lokasi lain
        // Contoh: $product->image = $imageName;

        return back()->with('success', 'Gambar berhasil disimpan.');
    }
}
