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
use App\Models\Api\ApiMatch as Match;
use App\Models\Api\ApiSeries as Series;
use App\Models\Api\ApiSeriesMatches as SeriesMatches;
use App\Models\Api\ApiSeriesTeam as SeriesTeam;

class MatchController extends Controller
{
    public function addMatch(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      =>  400,
                    'errors'    =>  '',
                    'message'   =>  'Invalid Token! User Not Found.',
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
                'teamA'	        => 'required',
                'teamB'         => 'required',
                'unique_id'     => 'required',
                'date'          => 'required',
                'dateTimeGMT'   => 'required',
                'type'          => 'required',
                'squad'         => 'required',
                'matchStarted'  => 'required',
            ];


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $newMatch = Match::create([
                    'teamA'     	=> $request->get('teamA'),
                    'teamB'     	=> $request->get('teamB'),
                    'unique_id' => $request->get('unique_id'),
                    'date'   => $request->get('date'),
                    'dateTimeGMT' => $request->get('dateTimeGMT'),
                    'type'   => $request->get('type'),
                    'squad' => $request->get('squad'),
                    'matchStarted'   => $request->get('matchStarted'),
                ]);
                
                if ($newMatch) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Match added Successfully';
                }
                
            }
        }
        
        return $response;
    }


    public function editMatch(Request $request)
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
            	'id'			=> ['required','exists:matches,id'],
                'teamA'			=> 'required',
                'teamB'     	=> 'required',
                'startDateTime' => 'required',
                'endDateTime'   => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();

            }
            else
            {

                $newMatch = Match::where('id','=',$request->id)->update([
                    'teamA'     	=> $request->get('teamA'),
                    'teamB'     	=> $request->get('teamB'),
                    'startDateTime' => $request->get('startDateTime'),
                    'endDateTime'   => $request->get('endDateTime'),
                ]);
                
                if ($newMatch) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Match updated Successfully';
                }
                
            }
        }
        
        return $response;
    }

    public function deleteMatch(Request $request)
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
            	'id'			=> ['required','exists:matches,id'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {

                $match = Match::find($request->id);
                
                if ($match->delete()) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['message']    = 'Match deleted Successfully';
                }
                
            }
        }
        
        return $response;
    }


    public function listMatches(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      =>  400,
                    'errors'    =>  '',
                    'message'   =>  'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user) )
        {

            $series = Series::where('status','Active')->first();

                    $seriesId   =  $series->id;
                    $allMatches =  Match::where('seriesId', '=', $seriesId)->get();
                    
                    foreach($allMatches as $match)
                    {
                        $seriesTeamsA = SeriesTeam::find($match->teamAId);
                        $match['teamAImage'] = $seriesTeamsA->image;

                        $seriesTeamsB = SeriesTeam::find($match->teamBId);
                        $match['teamBImage'] = $seriesTeamsB->image;
                    }
                    if (!empty($allMatches)){

                        $response['data']['code']       = 200;
                        $response['status']             = true;
                        $response['data']['result']    	= $allMatches;
                        $response['data']['message']    = 'Request Successfull';

                    } else {

                        $response['data']['code']       = 400;
                        $response['status']             = flase;
                        $response['data']['message']    = 'No Matches Found!';
                    }


            // $matches = Match::all();

            // foreach ($matches as $match) 
            // {
            //     $myTime = $match->dateTimeGMT;

                // $TAR =  explode(" ",$match->teamA);
                // $TA = substr($TAR[0], 0, 1).substr($TAR[1], 0, 1);

                // $TBR =  explode(" ",$match->teamB);
                // $TB = $TBR[0];
                // $TB = substr($TBR[0], 0, 1).substr($TBR[1], 0, 1);
                


                

                // $match['dateTimePKT'] = date('Y-m-d g:i A',strtotime($myTime."+5 Hours"));
                // $match['dropdownMatchs'] = $TA." VS ".$TB." (".date('M-d g:i A',strtotime($myTime."+5 Hours")).")";
                // $match['dropdownMatchs'] = "PAK VS AUS". " (".date('M-d g:i A',strtotime($myTime."+5 Hours")).")";
                
            // }
        }
        return $response;
    }

    public function allTeams(Request $request)
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
            
                $series = Series::where('status', '=', 'Active')->first();

                $seriesId = $series->id;
                
                $teams = SeriesTeam::where('seriesId','=',$seriesId)->get();

                if ($teams) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $teams;
                    $response['data']['message']    = 'Request Successfull';
                }else{
                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Request Unsuccessfull';
                }
                
        }
        
        return $response;
    }


    public function addTeam(Request $request)
    {
        $rules = [
            'team'			 =>  'required',
            'image'     	 =>  'required',
            'seriesId'       =>  'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($rules);
        } else {

            $image = $request->file('image');

            $filename = time() . '.'. $image->getClientOriginalExtension();

            $path =  \Storage::disk('public')->put('filename', $image);
            
            $team = SeriesTeam::create([
                
                'team'     => $request->get('team'),
                'image'    => $filename,
                'seriesId' => $request->get('seriesId'),

            ]); 

            
            // $file = $request->file('image');

            // \Storage::disk('public')->put('filename', $file);

            $id = $team->seriesId;
            
            if ($team->save()) {
                return redirect("view-teams/$id");
            }
        }
        return $response;
    }

        /* ============ Show all the Active/Inactive series ============ */

        public function show($id)
        {
            $teams  =  SeriesTeam::all();
            if ( !empty($teams)) {
    
                return view('teams.viewTeams',compact('teams','id'));
            }
        }


}
