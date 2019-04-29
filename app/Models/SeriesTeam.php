<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesTeam extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'series_teams';

    protected $fillable = [

        'team',
        'image',
        'seriesId',
        // 'createdAt',
        // 'updatedAt'
    ];
}
