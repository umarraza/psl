<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamOwner extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'team_owners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'mobileNumber',
        'teamMembers',
        'moves',
        'userId',
        'amountInAccount'
        // 'createdAt',
        // 'updatedAt'
    ];

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','userId');
    }

    public function getArrayResponse() {
        return [
             'firstName'        => $this->firstName,
             'lastName'         => $this->lastName,
             'mobileNumber'     => $this->mobileNumber,
             'userId'  		    => $this->userId,
             'teamMembers'      => $this->teamMembers,
             //'movesUsed'        => 125 - $this->moves,
             //'moves'            => 125,
             'movesUsed'        => 50 - $this->moves,
             'moves'            => 50,
             'total_points'     => $this->total_points,
             'amountInAccount'  => $this->amountInAccount,
        ];
    }
}
