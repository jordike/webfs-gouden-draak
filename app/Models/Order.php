<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public $timestamps = false;

    protected $fillable = [
        'date_placed'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function parts()
    {
        return $this->hasMany(OrderPart::class, 'order_id', 'id');
    }
}
