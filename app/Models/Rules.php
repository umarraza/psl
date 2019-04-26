<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'rules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'condition',
        'points',
    ];



    public function getArrayResponse() {
        return [
            'id'         =>  $this->id,
            'condition'  =>  $this->condition,
            'points'     =>  $this->points,
        ];
    }
}
