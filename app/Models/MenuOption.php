<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    protected $table = 'menu_options';

    protected $fillable = [
        'name',
        'price'
    ];
}
