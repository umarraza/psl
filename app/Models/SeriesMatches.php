<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesMatches extends Model
{

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'matches';

    protected $fillable = [
        'teamA',
        'teamB',
        'teamAId',
        'teamBId',
        'unique_id',
        'date',
        'dateTimeGMT',
        'type',
        'squad',
        'matchStarted',
        'seriesId',

        // 'createdAt',
        // 'updatedAt'
    ];

    public $timestamps = false;
}
