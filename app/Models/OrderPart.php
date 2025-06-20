<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPart extends Model
{
    protected $table = 'order_parts';

    protected $fillable = [
        'order_id',
        'part_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
