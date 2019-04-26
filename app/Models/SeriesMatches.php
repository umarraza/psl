<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesMatches extends Model
{

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'series_matches';

    protected $fillable = [
        'teamA',
        'teamB',
        'dateTimeGMT',
        'startingTime',
        'endingTime',
        'format',
        'status',
        'seriesId',
        // 'createdAt',
        // 'updatedAt'
    ];

    public $timestamps = false;
}
