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
use App\Models\Api\ApiPlayer as Player;
use App\Models\Api\ApiMatchWiseTeamRecord as MatchWiseTeamRecord;
class TeamOwnerController extends Controller
{
    public function signUp(Request $request)
    {
    	
        $response = [
            'data' => [
                'code' => 400,
                'message' => 'Something went wrong. Please try again later!',
            ],
           'status' => false
        ];
        $rules = [
            'password'		=> 'required',
            'firstName'     => 'required',
            'lastName'      => 'required',
            'username'      => ['required', 'email', 'max:191', Rule::unique('users')],
            'mobileNumber'  => 'required',
            'language'      => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['data']['message'] = 'Invalid input values.';
            $response['data']['errors'] = $validator->messages();
        }else
        {

            $rolesId = Roles::findByAttr('label',User::TEAM_OWNER)->id;

            // First Enter Data in users Table
            $modelUser = User::create([
                'username'  => $request->get('username'),
                'password'  => bcrypt($request->get('password')),
                'resetPasswordToken' => $request->get('password'),
                'roleId'    => $rolesId,
                'verified'  => User::STATUS_ACTIVE,
                'language'  => $request->get('language'),
            ]);
            // Now Enter Data in Team Owner table
            if($modelUser){
                $teamOwner = TeamOwner::create([
                    'firstName'             => $request->get('firstName'),
                    'lastName'              => $request->get('lastName'),
                    'mobileNumber'          => $request->get('mobileNumber'),
                    'userId'                => $modelUser->id,
                    'moves'                 => 120,
                    'amountInAccount'       => 1100000000,
                ]);
                
                if ($teamOwner) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Team Owner SignUp Successfully';
                }
            }
        }
        
        return $response;
    }
    // haseeb

public function listTopTen(Request $request)
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
       if(!empty($user))
       {

           $response = [
               'data' => [
                   'code' => 400,
                   'message' => 'Something went wrong. Please try again later!',
               ],
              'status' => false
           ];
           
           
            

           $teamOwners = TeamOwner::orderBy('total_points','desc')->limit(10)->get();
           
           $teamOwnersz = TeamOwner::orderBy('total_points','desc')->get();
            $count = 0;
            $checkZero = 0;
            foreach ($teamOwnersz as $owner ) {
                $count++;
                if($owner->total_points==0)
                {
                    $checkZero++;
                }
                if($owner->id==$user->teamOwner->id)
                {
                    break;
                }
            }
            
            if($checkZero == $count)
            {
                $count=0;
                $teamOwners = [];
            }
           $response['data']['code']                   = 200;
           $response['status']                         = true;
           $response['data']['result']['teamData']     = $teamOwners;
           $response['data']['result']['ownerData']   = $user->teamOwner->getArrayResponse();
           $response['data']['result']['ownerRank']    = $count."/5000";
           $response['data']['message']                = 'Request Successfull';

       }
       return $response;
   }

    //haseeb

    public function updateInformation(Request $request)
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
                'value'         => ['required'],
                'filter'        => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $filter = $request->filter;

                if($filter=='firstName')
                {
                    $teamOwner = TeamOwner::where('userId','=',$user->id)->first();

                    if(!empty($teamOwner))
                    {
                        $teamOwner->firstName = $request->get('value');
                        
                        if($teamOwner->save())
                        {
                            $response['data']['code']       = 200;
                            $response['data']['message']    = 'First Name Changed Successfully';
                            $response['status']             = true;
                        }
                    }
                    else
                    {
                        $response['data']['code']       = 400;
                        $response['data']['message']    = 'Request Unsuccessfull';
                        $response['status']             = false;
                    }
                }
                elseif($filter=='lastName')
                {
                    $teamOwner = TeamOwner::where('userId','=',$user->id)->first();

                    if(!empty($teamOwner))
                    {
                        $teamOwner->lastName = $request->get('value');
                        
                        if($teamOwner->save())
                        {
                            $response['data']['code']       = 200;
                            $response['data']['message']    = 'Last Name Changed Successfully';
                            $response['status']             = true;
                        }
                    }
                    else
                    {
                        $response['data']['code']       = 400;
                        $response['data']['message']    = 'Request Unsuccessfull';
                        $response['status']             = false;
                    }
                }
                elseif($filter=='username')
                {
                    if($user->username == $request->get('value'))
                    {
                        $response['data']['code']       = 200;
                        $response['data']['message']    = 'Username Changed Successfully';
                        $response['status']             = true;
                    }
                    else
                    {
                        $availablityStatus = User::where('username','=',$request->get('value'))->first();
                        if(empty($availablityStatus))
                        {
                            $user->username = $request->get('value');
                            
                            if($user->save())
                            {
                                $response['data']['code']       = 200;
                                $response['data']['message']    = 'Username Changed Successfully';
                                $response['status']             = true;
                            }
                        }
                        else
                        {
                            $response['data']['code']       = 400;
                            $response['data']['message']    = 'The username already exist';
                            $response['status']             = false;
                        }
                    }

                }
                elseif($filter=='photo')
                {
                    if($request->get('value') != "DeletePhoto")
                    {
                        $file_data = $request->get('value');

                        @list($type, $file_data) = explode(';', $file_data);
                        @list(, $file_data) = explode(',', $file_data); 
                        @list(, $type) = explode('/', $type);

                        $file_name = 'image_'.time().'.'.$type; //generating unique file name;
                        
                        if($file_data!=""){ // storing image in storage/app/public Folder 
                            \Storage::disk('public')->put($file_name,base64_decode($file_data)); 
                            
                            $user->avatarFilePath= $file_name;

                            if ($user->save())
                            {
                                $response['data']['message'] = 'Request Successfull';
                                $response['data']['code'] = 200;
                                $response['data']['result'] = $user->avatarFilePath;
                                $response['status'] = true;
                            }
                        }
                        else
                        {
                                $response['data']['message'] = 'File Required';
                                $response['data']['code'] = 400;
                                $response['status'] = false;
                        }
                    }
                    else
                    {
                        $user->avatarFilePath= null;

                        if ($user->save())
                        {
                            $response['data']['message'] = 'Request Successfull';
                            $response['data']['code'] = 200;
                            $response['data']['result'] = $user->avatarFilePath;
                            $response['status'] = true;
                        }
                    }
                }
                elseif($filter=='password')
                {
                    $user->password = bcrypt($request->get('value'));
                    
                    if($user->save())
                    {
                        $response['data']['code']       = 200;
                        $response['data']['message']    = 'Password Changed Successfully';
                        $response['status']             = true;
                    }
                }
            }
        }
        return $response;
    }

    public function updateTeamMembers(Request $request)
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
        $appStopStatus = AppCommand::find(1);
        if($appStopStatus->status==1)
        {
            $response = [
                'data' => [
                    'code' => 410,
                    'message' => 'Sorry you can not update your players at this time.',
                ],
               'status' => false
            ];
            return $response;
        }
        if(!empty($user) )
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'teamData'          => ['required','json'],
                'amountInAccount'   => ['required'],
                'moves'             => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $rules = [
                    '*.playerId'       => ['required','exists:players,id']
                ];

                $validator = Validator::make(json_decode($request->teamData, true), $rules);
                if ($validator->fails()){
                    $response['data']['message'] = 'Invalid input values.';
                    $response['data']['errors'] = $validator->messages();
                }
            }
            if(empty($response['data']['errors']))
            {
                $teamOwner = TeamOwner::where('id','=',$user->teamOwner->id)->first();

                $myMoves = $teamOwner->moves-$request->moves; 
                
                {
                    $ownerId = $user->teamOwner->id;
                    $oldTeamMembers = TeamMember::where('ownerId','=',$ownerId)->delete();
                    $teamData = json_decode($request->teamData);
                    $teamArr = [];
                    if(count($teamData)<12)
                    {
                        foreach ($teamData as $value) 
                        {
                            $player = Player::find($value->playerId);
                            $newTeam = TeamMember::create([
                                    'playerId' => $value->playerId,
                                    'pid'      => $player->pid,
                                    'points'   => 0,
                                    'matchRole'=> $value->matchRole,
                                    'ownerId'  => $ownerId
                            ]);
                            $teamArr[] = $newTeam->getArrayResponse();
                        }
                        
    
                        $teamOwner->amountInAccount = $request->get('amountInAccount');
                        if($teamOwner->moves>0)
                        {
                            if(($teamOwner->moves - $request->moves)<0 )
                            {
                                $pointsToMinus = ($teamOwner->moves - $request->moves)*(-1);
                                $teamOwner->total_points = $teamOwner->total_points - ($pointsToMinus*20); 
                            }
                        }
                        else
                        {
                            $teamOwner->total_points = $teamOwner->total_points - ($request->moves*20);
                        }
                        
                        $teamOwner->moves = $teamOwner->moves - $request->get('moves');
                        
                        $teamOwner->save();
                        
                        
                        //if($myMoves>0)
                        {
                            $myMoves = 50 - ($myMoves);
                        }
                        // else
                        // {
                        //     $myMoves = 50 - $myMoves;
                        // }
                        
                        $teamOwner['movesUsed'] = $myMoves;//50 - $teamOwner->moves;
    
                        // $team_owner = TeamOwner::where('id','=',$user->teamOwner->id)->update([
                        //         'amountInAccount'       => $request->get('amountInAccount'),
                        // ]);
                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']['team'] = $teamArr;
                        $response['data']['result']['owner'] = $teamOwner;
                        $response['data']['message']    = 'Request Successfull';
                    }
                    else
                    {
                            $response = [
                                'data' => [
                                    'code' => 410,
                                    'message' => 'Sorry you can not add more then 11 players.',
                                ],
                               'status' => false
                            ];
                            return $response;
                    }
                }
                // else
                // {
                //     $response['data']['code']       = 400;
                //     $response['status']             = false;
                //     $response['data']['message']    = 'Insufficient moves';
                // }
            }
        }
        return $response;   
    }

    public function updateTeamMembersOld(Request $request)
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
                'teamMembers'       => 'required',
                'amountInAccount'   => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $team_owner = TeamOwner::where('id','=',$user->teamOwner->id)->update([
                        'teamMembers'           => $request->get('teamMembers'),
                        'amountInAccount'       => $request->get('amountInAccount'),
                ]);
                
                if ($team_owner) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Team Members updated Successfully';
                }        
            }
        }
        return $response;
    }

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
        if(!empty($user) && $user->isTeamOwner())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            

            $teamMembers = TeamMember::where('ownerId','=',$user->teamOwner->id)->get();
            
            $resultArray = [];
            foreach ($teamMembers as $member) {
                $resultArray[] = $member->getArrayResponse();
            }

            
            $response['data']['code']                   = 200;
            $response['status']                         = true;
            $response['data']['result']['teamData']     = $resultArray;
            $response['data']['result']['ownerData']    = $user->teamOwner->getArrayResponse();
            $response['data']['message']                = 'Request Successfull';
        
        }
        return $response;
    }

    public function getTeamOwnerData(Request $request)
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

            $teamOwners = TeamOwner::orderBy('total_points','desc')->get();
            $count = 0;
            $checkZero = 0;
            foreach ($teamOwners as $owner ) {
                $count++;
                if($owner->total_points==0)
                {
                    $checkZero++;
                }
                if($owner->id==$user->teamOwner->id)
                {
                    break;
                }
            }
            
            if($count==$checkZero)
                $count=0;
            
            $response['data']['code']                   = 200;
            $response['status']                         = true;
            $response['data']['result']['ownerData']    = $user->teamOwner->getArrayResponse();
            $response['data']['result']['ownerRank']    = $count."/5000";
            $response['data']['message']                = 'Request Successfull';
        
        }
        return $response;
    }

    public function listTeamMembersOld(Request $request)
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
            

            $teamOwner = TeamOwner::find($user->teamOwner->id);

            $arrLength  = sizeof(json_decode($teamOwner->teamMembers));
            $membersArr = json_decode($teamOwner->teamMembers);

            $teamPlayers = array();
            for($i=0 ; $i<$arrLength ; $i++)
            {
                $teamPlayers[] = Player::find($membersArr[$i]);
            }

            
            $response['data']['code']       = 200;
            $response['status']             = true;
            $response['data']['result']     = $teamPlayers;
            $response['data']['message']    = 'Team Members updated Successfully';
        
        }
        return $response;
    }
    
    public function upMy()
    {
        // $matcWiseRecord = MatchWiseTeamRecord::where('playerId','=',281)->where('matchId','=',18)->where('pid','=',960361)->where('matchRole','=',"Man Of Match")->get();
        // $arr1=[];
        // foreach ($matcWiseRecord as $mm ) 
        // {
        //     $owner = TeamOwner::find($mm->ownerId);
        //     $arr1[]=$owner;
        //     $oldPoints = $owner->total_points;
            
        //     $owner->total_points = $oldPoints + 310;//$mm->points;
        //     $owner->save();
        //     $arr1[]=$owner;
        // }
        // return $arr1;
        
        //  $teamOwner =  TeamOwner::all();
        
        //  $arr = [];
        
        // foreach($teamOwner as $o)
        // {
        //     $teamMembersCount = TeamMember::where('ownerId','=',$o->id)->count();
        //     if($teamMembersCount>11)
        //     {
        //         //$teamO = TeamOwner::where('id','=',$o->id)->update(["amountInAccount"=>"1100000000"]);
        //         //if($teamO)
        //         {    
        //             $arr[] = ["ownerId"=>$o->id , "count"=>$teamMembersCount];
                    
        //             // $teamMemberqqq = TeamMember::where('ownerId','=',$o->id)->delete();
        //         }
        //     }
        // }
        
        // return $arr;
        //return "hahaha";
        
        
        // $teamOwners = TeamOwner::all();
        // foreach ($teamOwners as $owner ) 
        // {
        //     $myPoints = MatchWiseTeamRecord::where('ownerId','=',$owner->id)->sum('points');
            
        //     $myOwner = TeamOwner::find($owner->id);
        //     $myOwner->total_points = $myPoints;
        //     $myOwner->save();
        // }
        
        // return "success";
    }
}
