<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'stock',
        'price',
        'clicks',
        'product_category_id',
    ];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // Relasi ke Order Item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Cart Item
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}