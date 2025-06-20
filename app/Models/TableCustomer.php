<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableCustomer extends Model
{
    protected $fillable = [
        'table_id',
        'name',
        'age'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
