<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'user_id',
        'total_amount',
        'status', // pending, processing, completed, canceled
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /* HAPUS/COMMENT METHOD INI AGAR ROUTE ADMIN MENGGUNAKAN ID
    public function getRouteKeyName()
    {
        return 'order_number';
    }
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}