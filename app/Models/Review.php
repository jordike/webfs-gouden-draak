<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'rating',
        'atmosphere_rating',
        'service_rating',
        'favorite_food',
        'improvement_suggestions',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
