<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'category_name',
        'name',
        'description',
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_name', 'name');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
