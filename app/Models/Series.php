<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'cric-series';

    protected $fillable = [
        'name',
        'seriesName',
        'status',
        'type',
        // 'createdAt',
        // 'updatedAt'
    ];
}
