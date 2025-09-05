<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function index()
    {
        $data = Product::latest()->get();
        return view('backoffice.product.index', compact('data'));
    }


    public function create()
    {
        $categories = Category::where('enabled', 1)->latest()->get();
        return view('backoffice.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dasar
        $rules = [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'unit'        => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:2048', // wajib upload
            'enabled'     => 'required|boolean',
            'is_variant'  => 'required|boolean',
        ];

        // Jika bukan varian → price & stock wajib
        if ($request->is_variant == 0) {
            $rules['price'] = 'required|numeric|min:0';
            $rules['stock'] = 'required|integer|min:0';
        }

        // Jika varian → pastikan variants ada
        if ($request->is_variant == 1) {
            $rules['variants'] = 'required|array|min:1';
            $rules['variants.*.name']  = 'required|string|max:255';
            $rules['variants.*.price'] = 'required|numeric|min:0';
            $rules['variants.*.stock'] = 'required|integer|min:0';
            $attr['price'] = 0;
            $attr['stock'] = 0;
        }

        $attr = $request->validate($rules);


        // 2. Generate slug
        $attr['slug'] = Str()->slug($attr['name']);

        // 3. Upload image ke storage (folder: products)
        $img = $request->file('image')->store('products');
        $attr['image'] = $img;

        // 4. Simpan ke database
        $product = Product::create($attr);

        // 5. Jika ada varian, simpan ke tabel product_variants
        if ($request->is_variant == 1 && $request->has('variants')) {
            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name'       => $variant['name'],
                    'price'      => $variant['price'],
                    'stock'      => $variant['stock'],
                ]);
            }
        }
        // 5. Redirect dengan pesan sukses
        return redirect()->route('product.index')->with('success', 'Created new product successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('enabled', 1)->latest()->get();
        return view('backoffice.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi
        $attr = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'nullable|numeric|min:0', // boleh kosong kalau ada varian
            'stock'       => 'nullable|integer|min:0', // boleh kosong kalau ada varian
            'unit'        => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'enabled'     => 'required|boolean',
            'is_variant'  => 'nullable|boolean',
        ]);

        // Slug
        $attr['slug'] = Str()->slug($attr['name']);

        // Jika ada upload baru
        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $attr['image'] = $request->file('image')->store('products');
        }

        // Atur harga & stok jika produk punya varian
        if ($request->boolean('is_variant')) {
            $attr['price'] = 0;
            $attr['stock'] = 0;

            // Kalau ada data varian (nanti dari form input array)
            if ($request->has('variants')) {
                // Hapus varian lama biar clean
                $product->variants()->delete();

                foreach ($request->variants as $variant) {
                    if (!empty($variant['name'])) {
                        $product->variants()->create([
                            'name'  => $variant['name'],
                            'price' => $variant['price'] ?? 0,
                            'stock' => $variant['stock'] ?? 0,
                        ]);
                    }
                }
            }
        }

        // Update data produk
        $product->update($attr);



        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar lama
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    public function setActive($id)
    {
        $data = Product::findOrFail($id);
        if ($data->enabled == 1) {
            $data->update(['enabled' => 0]);
            return redirect()->back()->with('success', $data->name . " has been nonactived");
        } else {
            $data->update(['enabled' => 1]);
            return redirect()->back()->with('success', $data->name . " has been actived");
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $img = $request->file('upload')->store('media');
            $url = asset("/storage/" . $img);

            return response()->json(['fillname' => $request->file('upload')->getClientOriginalName(), 'uploaded' => 1, 'url' => $url]);
        }
    }
}
