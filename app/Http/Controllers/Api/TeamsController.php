<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use JWTAuthException;
use JWTAuth;

use App\Models\Api\ApiUser as User;
use App\Models\Api\ApiMatch as Match;
use App\Models\Api\ApiSeries as Series;
use App\Models\Api\ApiSeriesMatches as SeriesMatches;
use App\Models\Api\ApiSeriesTeam as SeriesTeam;


class TeamsController extends Controller
{


    public function check(Request $request)
    {
        $response = [
            'data' => [
                'code' => 400,
                'message' => 'Something went wrong. Please try again later!',
            ],
            'status' => false
        ];
        $rules = [
            'teamData'    =>   'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['data']['message'] = 'Invalid input values.';
            $response['data']['errors'] = $validator->messages();
        }
        else
        {
            $id           =   $request->id;
            $teamMembers  =   TeamMember::find($id);
            $playerData   =   $teamMembers->playerData;
            $ownerId      =   $teamMembers->ownerId;
            $member       =   MatchWiseTeamRecord::create([

                                "matchId" => $id,
                                "ownerId" => $ownerId,
                                "playerData" => $playerData,
                            ]);

            if($member->save())
            {
                $response['data']['code']       = 200;
                $response['status']             = true;
                $response['data']['result']     = $member;
                $response['data']['message']    = 'Request successfull';
            }
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

    public function show($id)
        {
            $teams  =  SeriesTeam::all();
            if ( !empty($teams)) {
    
                return view('teams.viewTeams',compact('teams','id'));
            }
        }

}
