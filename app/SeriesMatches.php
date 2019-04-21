<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesMatches extends Model
{
    protected $table = 'series_matches';

    protected $fillable = [
        'teamA',
        'teamB',
        'dateTimeGMT',
        'startingTime',
        'endingTime',
        'type',
        'format',
        'status',
        'seriesId',
        // 'createdAt',
        // 'updatedAt'
    ];
    
    public $timestamps = false;
}
