<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'team_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ownerId',
        'playerId',
        'points',
        'matchRole',
        'pid',
        // 'createdAt',
        // 'updatedAt'
    ];

    /**
     * @return mixed
     */
    public function owner()
    {
        return $this->hasOne(TeamOwner::class,'id','ownerId');
    }

    public function player()
    {
        return $this->hasOne(Player::class,'id','playerId');
    }

    public function getArrayResponse() {
        return [
             'id'        	=> $this->id,
             'player'     	=> $this->player->getArrayResponse(),
             'points'  		=> $this->points,
             'matchRole'    => $this->matchRole,
             'pid'    => $this->pid,
        ];
    }
}
