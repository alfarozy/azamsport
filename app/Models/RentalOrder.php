<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{

    protected $table = 'rental_orders';

    protected $fillable = [
        'order_number',
        'product_id',
        'quantity',
        'user_id',
        'rental_phone',
        'start_date',
        'end_date',
        'delivery_option',
        'delivery_address',
        'notes',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
