<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

//// JWT ////
use JWTAuthException;
use JWTAuth;

//// Models ////
use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiTeamOwner as TeamOwner;
use App\Models\Api\ApiTeamMember as TeamMember;
use App\Models\Api\ApiMatchWiseTeamRecord as MatchWiseTeamRecord;
use App\Models\MatchWiseTeamRecordTestVersion;
use App\Models\Api\ApiAppCommand as AppCommand;
use App\Models\Api\ApiPlayer as Player;
use App\Models\Api\ApiMatch as Match;


class RecordsController extends Controller
{
    public function listTeamMembers(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user)) //  && $user->isTeamOwner()
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'matchId'  =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = "Please select a match";
                $response['data']['errors'] = $validator->messages();
            }
            else
            {
            
                // $teamMembers   =   TeamMember::find(39);
                // $ownerId       =   $teamMembers->ownerId;
                // $data          =   $teamMembers->playerData;
                // $playerData    =   json_decode($data);
                $match = Match::find($request->matchId);
                $ownerId = $request->ownerId;
                if(!empty($match))
            	{
            		// if($match->type == "Twenty20,,")
            		{
			            $teamMembers = MatchWiseTeamRecord::where('ownerId','=',$ownerId)
			            									->where('matchId','=',$request->matchId)->first();
                    
                        $playerData = json_decode($teamMembers->playerData);
                        $playerArr = [];
                        foreach($playerData as $data )
                        {
                            
                            $player = Player::find($data->playerId);
                            $playerArr[]  = [

                                        "points"    => $data->points,
                                        "matchRole" => $data->matchRole,
                                        "player"    => $player->getArrayResponse(),
                                        
                            ];
                        }
                        $teamMembers['teamInfo'] = $playerArr;
                        // $resultArray = [];
			            // foreach ($teamMembers as $member) {
			            //     $resultArray[] = $member->getArrayResponse();
			            // }

			            $response['data']['code']                   = 200;
			            $response['status']                         = true;
                        $response['data']['result']['teamData']     = $teamMembers;
                        // $response['data']['result']['playerData']   = $playerData;
			            // $response['data']['result']['ownerId']      = $ownerId;
			            $response['data']['result']['ownerData']    = $user->teamOwner->getArrayResponse();
			            $response['data']['message']                = 'Request Successfull';
			        }
			        // else
			        // {
			        // 	$response['data']['code']                   = 405;
			        //     $response['status']                         = true;
			        //     $response['data']['message']                = 'Result is not available yet.';
			        // }
		        }
		        else
		        {
		        	$response['data']['code']                   = 400;
		            $response['status']                         = false;
		            $response['data']['message']                = 'Request Unsuccessfull';
		        }
	        }
        
        }
        return $response;
    }
    
    public function updateRecords(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user) && $user->isTeamOwner())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'matchId'       => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                
                $teamMembers =  TeamMember::all();
                foreach ($teamMembers as $member) {

                    $member = MatchWiseTeamRecord::create([
                                            "matchId" =>0,
                                            "playerId" => $member->playerId,
                                            "ownerId" => $member->ownerId,
                                            "points" => $member->points,
                                            "matchRole" => $member->matchRole,
                                            "playerId" => $member->playerId,
                                            "pid" => $member->pid,
                                        ]);
                }
                                        $response['data']['code']                   = 200;
                        $response['status']                         = true;
                        $response['data']['result']['ownerData']    = $user->teamOwner->getArrayResponse();
                        $response['data']['message']                = 'Request Successfull';
                        
                        return $response;
                
                
                $matchId = $request->matchId;

                $match = Match::find($request->matchId);
                if(!empty($match))
                {
                    if($match->type == "Twenty20..")
                    {
                        $teamMembers =  TeamMember::all();
                        foreach ($teamMembers as $member) {

                            $member = MatchWiseTeamRecordTestVersion::create([
                                                                        "matchId" => $match->id,
                                                                        "playerId" => $member->playerId,
                                                                        "ownerId" => $member->ownerId,
                                                                        "points" => $member->points,
                                                                        "matchRole" => $member->matchRole,
                                                                        "playerId" => $member->playerId,
                                                                        "pid" => $member->pid,
                                                                    ]);
                        }

                        
                        $response['data']['code']                   = 200;
                        $response['status']                         = true;
                        $response['data']['result']['ownerData']    = $user->teamOwner->getArrayResponse();
                        $response['data']['message']                = 'Request Successfull';
                    }
                    else
                    {
                        $response['data']['code']                   = 405;
                        $response['status']                         = true;
                        $response['data']['message']                = 'Result is not available yet.';
                    }
                }
                else
                {
                    $response['data']['code']                   = 400;
                    $response['status']                         = false;
                    $response['data']['message']                = 'Request Unsuccessfull';
                }
            }
        
        }
        return $response;
    }
}
