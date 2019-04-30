<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchWiseTeamRecord extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'match_team_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matchId',
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

    public function getArrayResponse2() {
        return [
             'id'        	=> $this->id,
             'player'     	=> $this->player->getArrayResponse(),
             'points'  		=> $this->points,
             'matchRole'    => $this->matchRole,
             'pid'          => $this->pid,
        ];
    }

    public function getArrayResponse() {
        
        $playerData = json_decode($this->playerData);
        $playerArr  = [];

        foreach($playerData as $data )
        {
            $player = Player::find($data->playerId);

            $playerArr[] = [

                        "points"    => $data->points,
                        "matchRole" => $data->matchRole,
                        "pid"       => $data->pid,
                        "player"    => $player->getArrayResponse(),
                        
            ];
        }

        
        return [
             'id'        	=> $this->id,
             'ownerId'      => $this->ownerId,
             'matchId'      => $this->matchId,
             'player'     	=> $playerArr,
        ];
    }
}
