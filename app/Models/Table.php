<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'use_deluxe_menu'
    ];

    public function customers()
    {
        return $this->hasMany(TableCustomer::class);
    }
}
