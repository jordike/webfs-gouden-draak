<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    public $timestamps = false;

    protected $table = 'menu_categories';

    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'category_name', 'name');
    }
}
