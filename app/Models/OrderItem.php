<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'menu_item_id',
        'amount',
        'comment',
        'order_part_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function orderPart()
    {
        return $this->belongsTo(OrderPart::class);
    }
}
