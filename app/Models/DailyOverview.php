<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyOverview extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'date';

    protected $fillable = [
        'date',
        'file_path'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function getFilePath()
    {
        return storage_path('app/' . $this->file_path);
    }
}
