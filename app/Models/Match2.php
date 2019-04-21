<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match2 extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'matchesQ';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teamA',
        'teamB',
        'unique_id',
        'date',
        'dateTimeGMT',
        'type',
        'squad',
        'matchStarted',
    ];



    public function getArrayResponse() {
        return [
             'id'   			=> $this->id,
        	 'teamA'   			=> $this->teamA,
             'teamB'   			=> $this->teamB,
             'startDateTime'   	=> $this->startDateTime,
             'endDateTime'   	=> $this->endDateTime,
        ];
    }

    public static function stopApp()
    {
        
    }
}
