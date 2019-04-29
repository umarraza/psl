<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'players';

    protected $fillable = [
        'name',
        'designation',
        'price',
        'pid',
        'image',
        'nameOfTeam',
        'matchId',
        'seriesId',
        // 'createdAt',
        // 'updatedAt'
    ];
    
    public $timestamps = false;
}
