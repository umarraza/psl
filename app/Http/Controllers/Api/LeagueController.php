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
use App\Models\Api\ApiAppCommand as AppCommand;

use App\Models\Api\ApiLeagueMember as LeagueMember;
use App\Models\Api\ApiLeague as League;

use App\Models\Api\ApiPlayer as Player;

class LeagueController extends Controller
{
    public function addNewLeague(Request $request)
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
                'name'		=> 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$accessCode = time();
                
            	$league = new League();
            	$league->name = $request->get('name');
            	$league->code = $accessCode;
            	
            	if($league->save())
            	{
	                $leagueMember = LeagueMember::create([
	                    'memberId'    	=> $user->teamOwner->id,
	                    'memberRole'	=>	"Admin",
	                    'leagueId'		=>	$league->id,
	                ]);
	                
	                if ($leagueMember && $user->sendEmailCustomer($league->name,$league->code)) {
	                    $response['data']['code']       = 200;
	                    $response['status']             = true;
	                    $response['result']             = $accessCode;
	                    $response['data']['message']    = 'League created Successfully';
	                }
	            }
                
            }
        }
        
        return $response;
    }

    public function joinLeague(Request $request)
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
                'code'			=>  ['required','exists:leagues,code'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$league = League::where('code','=',$request->code)->first();

            	$checkAlreadyJoined = LeagueMember::
            								where('memberId','=',$user->teamOwner->id)
            								->where('leagueId','=',$league->id)
            								->first();
            	if(empty($checkAlreadyJoined))
            	{
	                $leagueMember = LeagueMember::create([
	                    'memberId'    	=> $user->teamOwner->id,
	                    'memberRole'	=>	"Normal",
	                    'leagueId'		=>	$league->id,
	                ]);
	                
	                if ($leagueMember) {
	                    $response['data']['code']       = 200;
	                    $response['status']             = true;
	                    $response['data']['message']    = 'League joined Successfully';
	                }
	            }
	            else
	            {
	            	    $response['data']['code']       = 400;
	                    $response['status']             = true;
	                    $response['data']['message']    = 'Already Member of this League';	
	            }
            }
        }
        
        return $response;
    }

    public function listLeagues(Request $request)
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
            

        	$leagues = LeagueMember::join('leagues', 'leagues.id', '=', 'league_members.leagueId')
        							->select("leagues.*","leagues.code as accessCode")
        							->where('memberId','=',$user->teamOwner->id)
        							->get();
            
            if ($leagues) {
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['result'] 	= $leagues;
                $response['data']['ownerData'] 	= $user->teamOwner->getArrayResponse();
                $response['data']['message']    = 'Request Successfull';
            }
                
            
        }
        
        return $response;
    }

    public function listLeagueTopTens(Request $request)
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
                'id'		=> ['required','exists:leagues,id'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	$league = League::find($request->id);
            	
            	
                $leagueMember = LeagueMember::where('leagueId','=',$league->id)->limit(10)->get();
                

                $arr=[];

                foreach ($leagueMember as $member) {
                	$arr[] = $member->memberId;
                }

                $teamOwners = TeamOwner::whereIn('id',$arr)->orderBy('total_points','desc')->limit(10)->get();
                
                
                $teamOwnersz = TeamOwner::whereIn('id',$arr)->orderBy('total_points','desc')->get();
                $count = 0;
                foreach ($teamOwnersz as $owner ) {
                    $count++;
                    if($owner->id==$user->teamOwner->id)
                    {
                        break;
                    }
                }
                
	                
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['result']     = $teamOwners;
                $response['data']['ownerRank']  = $count."/".count($arr);
                $response['data']['message']    = 'Request Successfull';
	                            
            }
        }
        
        return $response;
    }
    // haseeb work 

   
    public function deleteLeague(Request $request)
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
                'id'		=> ['required','exists:leagues,id'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
            	
                $leagueMember = LeagueMember::where('leagueId','=',$league->id)
                							->where('memberRole','=','Admin')
                							->first();

                if($user->teamOwner->id == $leagueMember->memberId)
                {
	                $leagueToDelete = League::where('id','=',$request->id)->delete();

	                $deleteLeagueMembers = LeagueMember::where('leagueId','=',$request->id)->delete();
		            
		            if($leagueToDelete && $deleteLeagueMembers)
		            {
		                $response['data']['code']       = 200;
		                $response['status']             = true;
		                $response['data']['message']    = 'Request Successfull';
	            	}
	            }
	            else
	            {
	            	$response['data']['code']       = 400;
	                $response['status']             = false;
	                $response['data']['message']    = 'Not allowed to delete league';
	            }            
            }
        }
        
        return $response;
    }
}
