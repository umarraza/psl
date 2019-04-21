<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'cric-series';

    protected $fillable = [
        'seriesName',
        'status',
        'type',
        // 'createdAt',
        // 'updatedAt'
    ];
    
    public $timestamps = false;

}
