<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RentalOrder;
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

    public function rentalStore(Request $request, $slug)
    {
        if (auth()->check()) {
            return redirect()->route('login')->with('msg', 'Silahkan login terlebih dahulu');
        }
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_address' => 'nullable|string|max:255',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:255',
            'rental_phone' => 'required|string|max:255',
        ]);

        // Hitung total hari
        $start = new \DateTime($request->start_date);
        $end   = new \DateTime($request->end_date);
        $days  = $start->diff($end)->days + 1;

        // Hitung total biaya
        $deliveryCost = $request->delivery_option === 'delivery' ? 20000 : 0;
        $totalCost    = ($product->price * $request->quantity * $days) + $deliveryCost;

        // Simpan data rental
        $rental = RentalOrder::create([
            'user_id'          => auth()->id(),
            'order_number'    => 'AZM-' . date('Ymd') . '-' . str_pad(RentalOrder::count() + 1, 3, '0', STR_PAD_LEFT),
            'product_id'       => $product->id,
            'quantity'         => $request->quantity,
            'rental_phone'     => $request->rental_phone,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'delivery_option'  => $request->delivery_option,
            'delivery_address' => $request->delivery_option === 'delivery' ? $request->delivery_address : null,
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
            'total_price'       => $totalCost,
            'status'           => 'pending', // default status
        ]);
        //> return ke detail invoice
        return redirect()->route('user.orders.invoice', $rental->order_number);
    }
}
