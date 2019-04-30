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
        'designation',
        'price',
        'pid',
        'image',
        'nameOfTeam',
        'seriesId'

    ];



    public function getArrayResponse() {
        return [
             'id'          => $this->id,
             'name'        => $this->name,
             'designation' => $this->designation,
             'price'       => $this->price,
             'pid'         => $this->pid,
             'nameOfTeam'  => $this->nameOfTeam,
             'seriesId'    => $this->seriesId,
             'image'       => "http://fantasycricleague.online/PSL/storage/app/public/".$this->image,
        ];
    }
}
