<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::where('enabled', true)->latest()->take(4)->get();
        return view('homepage.index', compact('products'));
    }
    public function products(Request $request)
    {
        // Ambil semua kategori aktif untuk ditampilkan di filter dropdown
        $categories = Category::where('enabled', true)->latest()->get();

        // Mulai query produk
        $query = Product::with('category')->where('enabled', true);

        // Jika ada filter kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Ambil produk terbaru
        $products = $query->latest()->paginate(12);

        return view('homepage.products', compact('categories', 'products'));
    }

    public function productDetail($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Ambil produk lain selain yang sedang dibuka (max 4)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('homepage.products-detail', compact('product', 'relatedProducts'));
    }

    public function rentalStore($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();
    }
}
