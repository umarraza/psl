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
use App\Models\Api\ApiPlayer as Player;
use App\Models\Api\ApiMatch as Match;
use App\Models\Api\ApiAppCommand as AppCommand;
use App\Models\Api\ApiSeries as Series;

use Carbon\Carbon;
class PlayerController extends Controller
{
    public function addPlayer(Request $request)
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
        if(!empty($user) && $user->isSuperAdmin())
        {
    	
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'name'		   => 'required',
                'price'        => 'required',
                'pid'          => 'required',
                'designation'  => 'required',
                'nameOfTeam'   => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $player = Player::create([
                    'name'                  => $request->get('name'),
                    'price'                 => $request->get('price'),
                    'pid'                 => $request->get('pid'),
                    'designation'                 => $request->get('designation'),
                    'nameOfTeam'                 => $request->get('nameOfTeam'),
                ]);
                
                if ($player) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Player added Successfully';
                }
                
            }
        }
        
        return $response;
    }

    public function addPlayerImage(Request $request)
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
        if(!empty($user) && $user->isSuperAdmin())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'id'     => 'required',
                'value'  => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $player =  Player::where('id','=',$request->id)->first();
                $file_data = $request->get('value');

                @list($type, $file_data) = explode(';', $file_data);
                @list(, $file_data) = explode(',', $file_data); 
                @list(, $type) = explode('/', $type);

                $file_name = 'image_'.time().'.'.$type; //generating unique file name;
                
                if($file_data!=""){ // storing image in storage/app/public Folder 
                    \Storage::disk('public')->put($file_name,base64_decode($file_data)); 
                    
                    $player->image = $file_name;

                    if ($player->save())
                    {
                        $response['data']['message'] = 'Request Successfull';
                        $response['data']['code'] = 200;
                        $response['data']['result'] = $player->image;
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
        }
        
        return $response;
    }

    public function addPlayerTeam(Request $request)
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
        if(!empty($user) && $user->isSuperAdmin())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'id'    => 'required',
                'nameOfTeam'      => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $player =  Player::where('id','=',$request->id)->first();
                $player->nameOfTeam = $request->nameOfTeam;
                if($player->save())
                {
                    $response['data']['message'] = 'Request Successfull';
                    $response['data']['code'] = 200;
                    $response['status'] = true;
                }
                else
                {
                    $response['data']['message'] = 'Request Unsuccessfull';
                    $response['data']['code'] = 400;
                    $response['status'] = false;
                }
                
            }
        }
        
        return $response;
    }

    public function editPlayer(Request $request)
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
        if(!empty($user) && $user->isSuperAdmin())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'id'        => ['required','exists:players,id'],
                'name'      => 'required',
                'price'     => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $player = Player::where('id','=',$request->id)->update([
                    'name'                  => $request->get('name'),
                    'price'                 => $request->get('price'),
                ]);
                
                if ($player) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Player updated Successfully';
                }
                
            }
        }
        return $response;
    }


    public function deletePlayer(Request $request)
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
        if(!empty($user) && $user->isSuperAdmin())
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
                'id'        => ['required','exists:players,id'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $player = Player::find($request->id);
                
                if ($player->delete()) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Player deleted Successfully';
                }
                
            }
        }
        
        return $response;
    }


    public function listPlayers(Request $request)
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
            
            $allSeries = Series::all();

            foreach ($allSeries as $series){
                if($series->status == 1){
                    $seriesId = $series->id;
                    $seriesPlayers = Player::where('seriesId', '=', $seriesId)->get();
                }
            }

            // $players = Player::all();
            // foreach ($players as $player) {
            //     $player['image'] = "http://fantasycricleague.online/PSL/storage/app/public/".$player['image'];
            // }
            $response['data']['code']       = 200;
            $response['data']['message']    = 'Request Successfull';
            $response['data']['result']     = $seriesPlayers;
            $response['status']             = true;    
        }
        return $response;
    }


    public function listPlayersWithoutToken()
    {
        
        $oldMatches = Match::where("matchStarted",'=',0)->get();
        foreach ($oldMatches as $value) 
        {
            $matchTime = Carbon::parse($value->dateTimeGMT);
            if($matchTime->isPast())
            {
                $updateMatch = Match::where('id','=',$value->id)->update([
                                            "matchStarted" => 1
                                        ]);
            }
        }


        $nextMatchRecord = Match::where("matchStarted",'=',0)->first();


        $currentTime = Carbon::now();
        $nextMatch = Carbon::parse($nextMatchRecord->dateTimeGMT);
        if($nextMatch->isFuture())
        {
            $difference = $nextMatch->diffInMinutes($currentTime);

            if($difference>5 && $difference<35)
            {
                $updateStopStatus = AppCommand::where('id','=',1)->update(['status'=> 0]);
            }
            else
            {
                $updateStopStatus = AppCommand::where('id','=',1)->where('status','=',0)->update(['status'=> 1]);
            } 
        }
        $response = [
            'data' => [
                'code' => 400,
                'message' => 'Something went wrong. Please try again later!',
            ],
           'status' => false
        ];
        
        $players = Player::all();
        foreach ($players as $player) {
            $player['image'] = "http://fantasycricleague.online/PSL/storage/app/public/".$player['image'];
        }
        $response['data']['code']       = 200;
        $response['data']['message']    = 'Request Successfull';
        $response['data']['result']     = $players;
        $response['status']             = true;    
    
        return $response;
    }
}
