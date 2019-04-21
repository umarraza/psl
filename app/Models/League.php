<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'leagues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code'
    ];

    /**
     * @return mixed
     */
    public function teamOwner()
    {
        return $this->hasOne(TeamOwner::class,'id','memberId');
    }

    public function getArrayResponse() {
        return [
             'id'			=> $this->id,
             'name'       	=> $this->name,
        ];
    }
}
