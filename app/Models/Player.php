<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'pid',
        'designation',
        'image',
        'nameOfTeam'
    ];



    public function getArrayResponse() {
        return [
             'id'     => $this->id,
             'name'     => $this->name,
             'price'    => $this->price,
             'pid'      => $this->pid,
             'nameOfTeam'      => $this->nameOfTeam,
             'designation'   => $this->designation,
             'image'   => "http://fantasycricleague.online/PSL/storage/app/public/".$this->image,
        ];
    }
}
