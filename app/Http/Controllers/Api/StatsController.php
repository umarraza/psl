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
use App\Models\Api\ApiMatchWiseTeamRecord as MatchWiseTeamRecord;
use App\Models\Api\ApiPlayer as Player;

class StatsController extends Controller
{
    public function updateStats(Request $request)
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

            $teamMembers = TeamMember::where('points', '!=', 0)->update(['points'=>0]);
            
            
            $api_url  = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=1157245";
            //  $api_url  = "http://cricapi.com/api/fantasySummary?apikey=<apikey>&unique_id=<unique_id>"

            //  Initiate curl
            $ch = curl_init();
            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$api_url);
            // Execute
            //$result=curl_exec($ch);
            $result=curl_exec($ch);
            // Closing
            curl_close($ch);

            $result = str_replace("4s","fourS",$result);
            $result = str_replace("6s","sixS",$result);
            $result = str_replace("man-of-the-match","man_of_the_match",$result);

            $teamMembers = TeamMember::where('points', '!=', 0)->update(['points'=>0]);
            // Will dump a json - you can save in variable and use the json
            $cricketMatches['result']=json_decode($result);
            //return $cricketMatches;
            //return $cricketMatches['result']->data->batting;
            foreach ($cricketMatches['result']->data->batting as $value) 
            {   
                $myObj = $value->scores;
                foreach ($myObj as $value2) 
                {
                    if($value2->SR=="" && $value2->sixS==""
                        && $value2->fourS=="" && $value2->B==""
                        && $value2->R=="" )
                    {
                        break;
                    }
                    
                    $pid = $value2->pid;
                    $pointsToAdd = 0;
                    // RUN RULES
                    if($value2->R<=50)
                    {
                        $pointsToAdd+=$value2->R;
                    }
                    elseif($value2->R>50 && $value2->R<=100)
                    {
                        $pointsToAdd+=$value2->R + 50;
                    }
                    else
                    {
                        $pointsToAdd+=$value2->R + 200;
                    }
                    
                    // Strike Rate RULES
                    if($value2->SR>=90 && $value2->SR<=99)
                    {
                        $pointsToAdd-=15;
                    }
                    elseif($value2->SR>=100 && $value2->SR<=119)
                    {
                        $pointsToAdd+=10;
                    }
                    elseif($value2->SR>=120 && $value2->SR<=150)
                    {
                        $pointsToAdd+=20;
                    }
                    elseif($value2->SR>=151 && $value2->SR<=200)
                    {
                        $pointsToAdd+=35;
                    }
                    elseif($value2->SR>200)
                    {
                        $pointsToAdd+=50;
                    }
                    else
                    {
                        $pointsToAdd-=20;
                    }

                    //4's Rules
                    $numOf4s = $value2->fourS;
                    $pointsToAdd+=($numOf4s*4);

                    //6's Rules
                    $numOf6s = $value2->sixS;
                    $pointsToAdd+=($numOf6s*6);

                    $pointsToAddCaptin = $pointsToAdd * 2;

                    $teamMembers = TeamMember::where('pid','=',$pid)->get();

                    foreach ($teamMembers as $teamMember) 
                    {
                        $singleValue = TeamMember::find($teamMember->id);

                        if($singleValue->matchRole == "Regular")
                            $singleValue->points = $pointsToAdd;
                        else
                            $singleValue->points = $pointsToAddCaptin;

                        $singleValue->save();
                    }
                }
            }
            //return $cricketMatches['result']->data->bowling;
            foreach ($cricketMatches['result']->data->bowling as $value) 
            {
                $myObj = $value->scores;
                foreach ($myObj as $value2) 
                {
                    if($value2->Econ=="" && $value2->W==""
                        && $value2->R=="" && $value2->M==""
                        && $value2->O=="" )
                    {
                        break;
                    }

                    $pid = $value2->pid;
                    $pointsToAdd = 0;
                    

                    // Wicket RULES
                    if($value2->W==1)
                    {
                        $pointsToAdd+=5;
                    }
                    elseif($value2->W==2)
                    {
                        $pointsToAdd+=20;
                    }
                    elseif($value2->W==3)
                    {
                        $pointsToAdd+=40;
                    }
                    elseif($value2->W>3)
                    {
                        $pointsToAdd+=100;
                    }
                    else
                    {
                        $pointsToAdd+=0;
                    }
                    
                    // Economy Rate RULES
                    if($value2->Econ<6.0)
                    {
                        $pointsToAdd+=50;
                    }
                    elseif($value2->Econ<7.0 )
                    {
                        $pointsToAdd+=20;
                    }
                    elseif($value2->Econ>=7.0 && $value2->Econ<8.0 )
                    {
                        $pointsToAdd-=15;
                    }
                    elseif($value2->Econ>=8.0 && $value2->Econ<=9.0 )
                    {
                        $pointsToAdd-=25;
                    }
                    else
                    {
                        $pointsToAdd-=35;
                    }

                    $pointsToAddCaptin = $pointsToAdd * 2;

                    $teamMembers = TeamMember::where('pid','=',$pid)->get();
                    foreach ($teamMembers as $teamMember) 
                    {
                        $singleValue = TeamMember::find($teamMember->id);

                        if($singleValue->matchRole == "Regular")
                            $singleValue->points = $singleValue->points + $pointsToAdd;
                        else
                            $singleValue->points = $singleValue->points + $pointsToAddCaptin;

                        $singleValue->save();
                    }
                } 
            }
            //return $cricketMatches['result']->data->fielding;
            foreach ($cricketMatches['result']->data->fielding as $value) 
            {
                $myObj = $value->scores;
                foreach ($myObj as $value2) 
                {

                    $pid = $value2->pid;
                    $pointsToAdd = 0;
                    

                    // Catch RULES
                    if($value2->catch>0)
                    {
                        $pointsToAdd+=5;
                    }
                    else
                    {
                        $pointsToAdd+=0;
                    }

                    // Stumped RULES
                    if($value2->stumped>0)
                    {
                        $pointsToAdd+=5;
                    }
                    else
                    {
                        $pointsToAdd+=0;
                    }

                    // RUNOUT RULES
                    if($value2->runout>0)
                    {
                        $pointsToAdd+=5;
                    }
                    else
                    {
                        $pointsToAdd+=0;
                    }

                    $pointsToAddCaptin = $pointsToAdd * 2;

                    $teamMembers = TeamMember::where('pid','=',$pid)->get();
                    foreach ($teamMembers as $teamMember) 
                    {
                        $singleValue = TeamMember::find($teamMember->id);

                        if($singleValue->matchRole == "Regular")
                            $singleValue->points = $singleValue->points + $pointsToAdd;
                        else
                            $singleValue->points = $singleValue->points + $pointsToAddCaptin;

                        $singleValue->save();
                    }
                } 
            }

            // MAN OF THE MATCH
            $man_of_the_match_pid = $cricketMatches['result']->data->man_of_the_match->pid;
            $teamMembers = TeamMember::where('pid','=',$man_of_the_match_pid)->get();
            
            foreach ($teamMembers as $teamMember) 
            {
                $singleValue = TeamMember::find($teamMember->id);

                $singleValue->points = $singleValue->points * 3;
                $singleValue->save();

            }

            //Update OWNER POINTS
            $owners = TeamOwner::select('id')->get();
            foreach ($owners as $owner) 
            {
                $teamSum  = TeamMember::where('ownerId','=',$owner->id)->sum('points');
                $ownerObj = TeamOwner::find($owner->id);
                //return $ownerObj;
                if(!empty($ownerObj))
                {   
                    $ownerObj->total_points = $ownerObj->total_points + $teamSum;
                    $ownerObj->save();
                }
            }
        }
    }
    
    public function abcTest(Request $request)
    {
        $teamMembers = MatchWiseTeamRecord::where('matchId','=',7)->where('playerId','=',248)->get();
        
        $arr = [];
        foreach ($teamMembers as $teamMember) 
        {
            $singleValue = MatchWiseTeamRecord::find($teamMember->id);
            $arr[] = $singleValue->ownerId; 
            // if($singleValue->matchRole == "Man Of Match")
            // {
            //     $singleValue->points = $singleValue->points * 3;
            //     $singleValue->save();
            // }

        }


        $owners = TeamOwner::select('id')->whereIn('id',$arr)->get();
        
                    foreach ($owners as $owner) 
                    {
                        $teamSum  = MatchWiseTeamRecord::select('points')->where('matchId','=',7)->where('ownerId','=',$owner->id)->where('playerId','=',248)->first();
                        //return $teamSum->points;
                        $ownerObj = TeamOwner::find($owner->id);
                        //return $ownerObj;
                        if(!empty($ownerObj))
                        {   
                            $ownerObj->total_points = $ownerObj->total_points + $teamSum->points;
                            $ownerObj->save();
                        }
                    }
        return $owners;
    }
}
