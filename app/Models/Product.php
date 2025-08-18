<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'price',
        'stock',
        'unit',
        'image',
        'enabled',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnail()
    {
        return asset('storage/' . $this->image);
    }
}
