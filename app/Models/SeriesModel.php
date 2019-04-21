<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesModel extends Model
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
