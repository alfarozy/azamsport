<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{

    protected $table = 'rental_orders';

    protected $fillable = [
        'product_id',        // produk yang disewa
        'quantity',          // jumlah item
        'rental_name',
        'rental_phone',
        'rental_address',
        'start_date',        // tanggal mulai
        'end_date',          // tanggal pengembalian
        'delivery_option',   // pickup / delivery
        'delivery_address',  // alamat jika delivery
        'notes',             // catatan khusus
        'total_price',       // total harga
        'status',            // pending, confirmed, cancelled, returned
        'payment_status',    // unpaid, paid
        'payment_method',    // transfer, qris, e-wallet
        'payment_proof',     // bukti bayar (jika ada)
    ];



    /**
     * Relasi ke Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
