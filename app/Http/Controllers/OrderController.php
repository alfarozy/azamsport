<?php

namespace App\Http\Controllers;

use App\Models\RentalOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $data = RentalOrder::with(['product'])->latest()->get();
        } else {
            $data = RentalOrder::with(['product'])->where('user_id', auth()->id())->latest()->get();
        }
        return view('backoffice.orders.index', compact('data'));
    }
    public function invoice($invoice)
    {
        if (auth()->user()->role === 'admin') {
            $order = RentalOrder::with(['product'])->where('order_number', $invoice)->first();
        } else {
            $order = RentalOrder::with(['product'])->where('user_id', auth()->id())->where('order_number', $invoice)->first();
        }

        return view('backoffice.orders.invoice', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $order = RentalOrder::findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // simpan file
        $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_proof' => $filePath,
            'payment_status' => 'waiting_confirmation'
        ]);

        return redirect()->route('user.orders.invoice', $order->order_number)->with('success', 'Bukti pembayaran berhasil diupload, menunggu konfirmasi admin.');
    }

    public function confirmPayment(Request $request, $id)
    {
        if (auth()->user()->role != 'admin') {
            return abort(404);
        }
        $order = RentalOrder::findOrFail($id);

        if ($order->status !== 'confirmed') {
            if ($order->payment_status !== 'waiting_confirmation') {
                return back()->with('error', 'Order ini tidak dalam status menunggu konfirmasi.');
            }
        }

        if ($request->input('action') === 'approve') {
            $order->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);
            // Tambahkan stok produk kembali
            if ($order->product) {
                $order->product->decrement('stock', $order->quantity);
            }
            return back()->with('success', 'Pembayaran berhasil disetujui.');
        }

        if ($request->input('action') === 'reject') {
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
            ]);
            return back()->with('error', 'Pembayaran ditolak, order dibatalkan.');
        }

        if ($request->input('action') === 'return') {
            $order->update([
                'status' => 'returned',
            ]);

            // Tambahkan stok produk kembali
            if ($order->product) {
                $order->product->increment('stock', $order->quantity);
            }

            return back()->with('success', 'Produk berhasil dikembalikan dan stok diperbarui.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}
