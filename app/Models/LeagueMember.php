<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMember extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'league_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'memberId',
        'memberRole',
        'leagueId'
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
             'memberDetails'	=> $this->teamOwner,
             'memberRole'       => $this->memberRole,
        ];
    }
}
