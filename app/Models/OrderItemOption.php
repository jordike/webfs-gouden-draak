<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemOption extends Model
{
    protected $table = 'order_item_options';

    protected $fillable = [
        'order_menu_item_id'
    ];

    public function menuOption()
    {
        return $this->belongsTo(MenuOption::class, 'menu_option_id', 'id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_menu_item_id', 'id');
    }
}
