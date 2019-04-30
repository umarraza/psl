<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Match2;
use Carbon\Carbon;
class AppCommand extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'apps_commands';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'command_name',
        'status',
    ];

    public function getArrayResponse() {
        return [
             'id'   			=> $this->id,
        	 'command_name'   	=> $this->command_name,
             'status'   		=> $this->status,
        ];
    }
    
    public static function matchesChecker0()
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
                // $nextMatchRecord->type = "ABHI ON HAA";
                // $nextMatchRecord->save();
                
                $updateStopStatus = AppCommand::where('id','=',1)->update(['status'=> 1]);
            }
            else
            {
                //$nextMatchRecord->type = json_encode($difference);//"Band haa";
                //$nextMatchRecord->save();
                
                $updateStopStatus = AppCommand::where('id','=',1)->where('status','=',0)->update(['status'=> 0]);
            } 
        }
        \Storage::disk('local')->put('qwerty.txt', 'Conteasasasqqqqqnasasts');
    }
    
    public static function matchesChecker()
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


        $nextMatchRecord = Match::where('matchStarted','=',1)->orderBy('id','desc')->first();

        $matchCronTimeStarted = Carbon::parse($nextMatchRecord->dateTimeGMT);
        //$matchEndPlusHours = $matchCronTimeStarted->copy()->addHour(3);
        //$matchEndPlusMinutes = $matchEndPlusHours->copy()->addMinute(30);
        
        $matchEndPlusHours = $matchCronTimeStarted->copy()->addHour(10);
        $matchEndPlusMinutes = $matchEndPlusHours->copy()->addMinute(30);

        if($matchEndPlusMinutes->isFuture())
        {
            if($nextMatchRecord->type == "Twenty20")
            {
                // Do insertion here. ChangeTwenty20..
                $teamMembers =  TeamMember::all();
                foreach ($teamMembers as $member) {

                    $member = MatchWiseTeamRecord::create([
                                            "matchId"    =>  $nextMatchRecord->id,
                                            "playerId"   =>  $member->playerId,
                                            "ownerId"    =>  $member->ownerId,
                                            "points"     =>  $member->points,
                                            "matchRole"  =>  $member->matchRole,
                                            "playerId"   =>  $member->playerId,
                                            "pid"        =>  $member->pid,
                                        ]);
                }
                
                $nextMatchRecord->type = "Twenty20..";
                $nextMatchRecord->save();
            }
            
            $updateStopStatus = AppCommand::where('id','=',1)->where('status','=',0)->update(['status'=> 1]);
        }
        else
        {
            $updateStopStatus = AppCommand::where('id','=',1)->where('status','=',1)->update(['status'=> 0]);
        }
        \Storage::disk('local')->put('qwerty.txt', 'Conteasasasqqqqqnasasts');
    }
    
    public static function statsChecker()
    {
        $matchesCron = Match::where('matchStarted','=',1)->orderBy('id','desc')->first();
        $myMatchId = $matchesCron->id; 
        $now = Carbon::now();

        $matchCronTimeStarted = Carbon::parse($matchesCron->dateTimeGMT);
        $matchEndPlusHours = $matchCronTimeStarted->copy()->addHour(10);
        $matchEndPlusMinutes = $matchEndPlusHours->copy()->addMinute(30);

        if($matchEndPlusMinutes->isPast())
        {
            //  $matchesCron->type = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=".$matchesCron->unique_id;
            //  $matchesCron->save();
            if($matchesCron->type=="Twenty20..")
            {
                // $matchesCron->type = "Twenty20,,";
                // $matchesCron->save();
                
                //$teamMembers = TeamMember::where('points', '!=', 0)->update(['points'=>0]);
                
                
                $api_url  = "http://cricapi.com/api/fantasySummary?apikey=mPtXJeL8a6V1p3caB20iKbbon503&unique_id=".$matchesCron->unique_id;
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
                if($cricketMatches['result']->data->man_of_the_match!="")
                {
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
                            if($value2->SR>=81 && $value2->SR<=90)
                            {
                                $pointsToAdd+=5;
                            }
                            elseif($value2->SR>=91 && $value2->SR<=99)
                            {
                                $pointsToAdd+=10;
                            }
                            elseif($value2->SR>=100 && $value2->SR<=119)
                            {
                                $pointsToAdd+=20;
                            }
                            elseif($value2->SR>=120 && $value2->SR<=150)
                            {
                                $pointsToAdd+=30;
                            }
                            elseif($value2->SR>=151 && $value2->SR<=200)
                            {
                                $pointsToAdd+=50;
                            }
                            elseif($value2->SR>200 && $value2->R>15)
                            {
                                $pointsToAdd+=60;
                            }
                            elseif($value2->SR<80 && $value2->SR>=70)
                            {
                                $pointsToAdd-=10;
                            }
                            else
                            {
                                $pointsToAdd-=30;
                            }
    
                            //4's Rules
                            $numOf4s = $value2->fourS;
                            $pointsToAdd+=($numOf4s*4);
    
                            //6's Rules
                            $numOf6s = $value2->sixS;
                            $pointsToAdd+=($numOf6s*6);
    
                        // ===================================================================================================== //

                            $pointsToAddCaptin = $pointsToAdd * 2;
    
                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$matchId)->where('playerData','like', '%' . $pid . '%')->get();
                            $playerData = "";

                            foreach ($teamMembers as $teamMember) 
                            {
                                $decodedData = json_decode($teamMember->playerData);
                                foreach($decodedData as $player)
                                {
                                    if($player->pid == $pid)
                                    {
                                        if($player->matchRole == "captain")
                                        {
                                            $player->points =  $pointsToAddCaptin;
                                        }
                                        else
                                        {
                                            $player->points =  $pointsToAdd;
                                        }
                                    }
                                }
                                $teamMember->playerData = json_encode($decodedData);
                                $teamMember->save();
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
                                $pointsToAdd+=10;
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
                            if($value2->Econ<4.0)
                            {
                                $pointsToAdd+=100;
                            }
                            elseif($value2->Econ<5.0 )
                            {
                                $pointsToAdd+=50;
                            }
                            elseif($value2->Econ<6.0 )
                            {
                                $pointsToAdd+=20;
                            }
                            elseif($value2->Econ>=6.0 && $value2->Econ<7.0 )
                            {
                                $pointsToAdd-=15;
                            }
                            elseif($value2->Econ>=7.0 && $value2->Econ<8.0 )
                            {
                                $pointsToAdd-=30;
                            }
                            else
                            {
                                $pointsToAdd-=50;
                            }
    
                    // ================================================== CAPTAIN =================================================== //

                            $pointsToAddCaptin = $pointsToAdd * 2;

                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$matchId)->where('playerData','like', '%' . $pid . '%')->get();
                            $playerData = "";

                            foreach ($teamMembers as $teamMember) 
                            {
                                $decodedData = json_decode($teamMember->playerData);
                                foreach($decodedData as $player)
                                {
                                    if($player->pid == $pid)
                                    {
                                        if($player->matchRole == "captain")
                                        {
                                            $player->points =  $pointsToAddCaptin;
                                        }
                                        else
                                        {
                                            $player->points =  $pointsToAdd;
                                        }
                                    }
                                }
                                $teamMember->playerData = json_encode($decodedData);
                                $teamMember->save();
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
                    // ===================================================================================================== //
    
                            $pointsToAddCaptin = $pointsToAdd * 2;
    
                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$matchId)->where('playerData','like', '%' . $pid . '%')->get();

                            $playerData = "";

                            foreach ($teamMembers as $teamMember) 
                            {
                                $decodedData = json_decode($teamMember->playerData);
                                foreach($decodedData as $player)
                                {
                                    if($player->pid == $pid)
                                    {
                                        if($player->matchRole == "captain")
                                        {
                                            $player->points =  $pointsToAddCaptin;
                                        }
                                        else
                                        {
                                            $player->points =  $pointsToAdd;
                                        }
                                    }
                                }
                                $teamMember->playerData = json_encode($decodedData);
                                $teamMember->save();
                            }
                        } 
                    }
    
                    // ================================================== MAN OF THE MATCH =================================================== //
                
                    $teamMembers = MatchWiseTeamRecord::where('matchId','=',$matchId)->where('playerData','like', '%' . $pid . '%')->get();
                    $playerData = "";
                    foreach ($teamMembers as $teamMember) 
                    {
                        $decodedData = json_decode($teamMember->playerData);
                        foreach($decodedData as $player)
                        {
                            if($player->pid == $pid)
                            {
                                if($player->matchRole == "Man Of Match")
                                {
                                    $player->points =  $player->points * 3;
                                }
                            }
                        }
                        $teamMember->playerData = json_encode($decodedData);
                        $teamMember->save();
                    }

                    // ====================================================================================================== //

                    $teamMembers = MatchWiseTeamRecord::where('matchId','=',$matchId)->where('playerData','like', '%' . $pid . '%')->get();
                    $playerData = "";
        
                    foreach ($teamMembers as $teamMember) 
                    {
                        $decodedData = json_decode($teamMember->playerData);
                        foreach($decodedData as $player)
                        {
                            if($player->pid == $pid)
                            {
                                if($player->matchRole == "Man Of Match")
                                {
                                    $player->points =  $player->points * 3;
                                }

                            }
                        }
                        $teamMember->playerData = json_encode($decodedData);
                        $teamMember->save();
                    }

                    //Update OWNER POINTS
                    $owners = TeamOwner::select('id')->get();
                    foreach ($owners as $owner) 
                    {
                        $teamSum  = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('ownerId','=',$owner->id)->sum('points');
                        $ownerObj = TeamOwner::find($owner->id);
                        //return $ownerObj;
                        if(!empty($ownerObj))
                        {   
                            $ownerObj->total_points = $ownerObj->total_points + $teamSum;
                            $ownerObj->save();
                        }
                    }
                    
                    $matchesCron->type = "Twenty20,,";
                    $matchesCron->save();
                }
                else
                {
                    \Storage::disk('local')->put('manOfMatch.txt', 'Conteasasasqqqqqnasasts');            
                }

            }

        }
        \Storage::disk('local')->put('qyhngsd.txt', 'Conteasasasqqqqqnasasts');
    }
    
    public static function statsCheckerPSL()
    {
        $matchesCron = Match::where('matchStarted','=',1)->orderBy('id','desc')->first();
        $myMatchId = $matchesCron->id; 
        $now = Carbon::now();

        $matchCronTimeStarted = Carbon::parse($matchesCron->dateTimeGMT);
        $matchEndPlusHours = $matchCronTimeStarted->copy()->addHour(3);
        $matchEndPlusMinutes = $matchEndPlusHours->copy()->addMinute(30);

        if($matchEndPlusMinutes->isPast())
        {
            //  $matchesCron->type = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=".$matchesCron->unique_id;
            //  $matchesCron->save();
            if($matchesCron->type=="Twenty20..")
            {
                // $matchesCron->type = "Twenty20,,";
                // $matchesCron->save();
                
                //$teamMembers = TeamMember::where('points', '!=', 0)->update(['points'=>0]);
                
                
                $api_url  = "http://cricapi.com/api/fantasySummary?apikey=mPtXJeL8a6V1p3caB20iKbbon503&unique_id=".$matchesCron->unique_id;
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
                if($cricketMatches['result']->data->man_of_the_match!="")
                {
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
    
                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('pid','=',$pid)->get();
    
                            foreach ($teamMembers as $teamMember) 
                            {
                                $singleValue = MatchWiseTeamRecord::find($teamMember->id);
    
                                if($singleValue->matchRole == "Captin")
                                    $singleValue->points = $pointsToAddCaptin;
                                else
                                    $singleValue->points = $pointsToAdd;
    
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
    
                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('pid','=',$pid)->get();
                            foreach ($teamMembers as $teamMember) 
                            {
                                $singleValue = MatchWiseTeamRecord::find($teamMember->id);
    
                                if($singleValue->matchRole == "Captin")
                                    $singleValue->points = $singleValue->points + $pointsToAddCaptin;
                                else
                                    $singleValue->points = $singleValue->points + $pointsToAdd;
    
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
    
                            $teamMembers = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('pid','=',$pid)->get();
                            foreach ($teamMembers as $teamMember) 
                            {
                                $singleValue = MatchWiseTeamRecord::find($teamMember->id);
    
                                if($singleValue->matchRole == "Captin")
                                    $singleValue->points = $singleValue->points + $pointsToAddCaptin;
                                else
                                    $singleValue->points = $singleValue->points + $pointsToAdd;
    
                                $singleValue->save();
                            }
                        } 
                    }
    
                    // MAN OF THE MATCH
                    $man_of_the_match_pid = $cricketMatches['result']->data->man_of_the_match->pid;
                    $teamMembers = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('pid','=',$man_of_the_match_pid)->get();
                    
                    foreach ($teamMembers as $teamMember) 
                    {
                        $singleValue = MatchWiseTeamRecord::find($teamMember->id);
    
                        if($singleValue->matchRole == "Man Of Match")
                        {
                            $singleValue->points = $singleValue->points * 3;
                            $singleValue->save();
                        }
    
                    }
    
                    //Update OWNER POINTS
                    $owners = TeamOwner::select('id')->get();
                    foreach ($owners as $owner) 
                    {
                        $teamSum  = MatchWiseTeamRecord::where('matchId','=',$myMatchId)->where('ownerId','=',$owner->id)->sum('points');
                        $ownerObj = TeamOwner::find($owner->id);
                        //return $ownerObj;
                        if(!empty($ownerObj))
                        {   
                            $ownerObj->total_points = $ownerObj->total_points + $teamSum;
                            $ownerObj->save();
                        }
                    }
                    
                    $matchesCron->type = "Twenty20,,";
                    $matchesCron->save();
                }
                else
                {
                    \Storage::disk('local')->put('manOfMatch.txt', 'Conteasasasqqqqqnasasts');            
                }

            }

        }
        \Storage::disk('local')->put('qyhngsd.txt', 'Conteasasasqqqqqnasasts');
    }
    public static function statsChecker0()
    {
        $matchesCron = Match::where('matchStarted','=',1)->orderBy('id','desc')->first();

        $now = Carbon::now();

        $matchCronTimeStarted = Carbon::parse($matchesCron->dateTimeGMT);
        $matchEndPlusHours = $matchCronTimeStarted->copy()->addHour(3);
        $matchEndPlusMinutes = $matchEndPlusHours->copy()->addMinute(15);

        if($matchEndPlusMinutes->isPast())
        {
            //  $matchesCron->type = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=".$matchesCron->unique_id;
            //  $matchesCron->save();
            if($matchesCron->type=="Twenty20QQ")
            {
                $matchesCron->type = "Twenty20..";
                $matchesCron->save();
                
                $teamMembers = TeamMember::where('points', '!=', 0)->update(['points'=>0]);
                
                
                $api_url  = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=".$matchesCron->unique_id;
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

                            if($singleValue->matchRole == "Captin")
                                $singleValue->points = $pointsToAddCaptin;
                            else
                                $singleValue->points = $pointsToAdd;

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

                            if($singleValue->matchRole == "Captin")
                                $singleValue->points = $singleValue->points + $pointsToAddCaptin;
                            else
                                $singleValue->points = $singleValue->points + $pointsToAdd;

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

                            if($singleValue->matchRole == "Captin")
                                $singleValue->points = $singleValue->points + $pointsToAddCaptin;
                            else
                                $singleValue->points = $singleValue->points + $pointsToAdd;

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

                    if($singleValue->matchRole == "Man Of Match")
                    {
                        $singleValue->points = $singleValue->points * 3;
                        $singleValue->save();
                    }

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
                
                $id           =  $request->id;
                $teamMembers  =  TeamMember::find($id);
                $playersData  =  $teamMembers->playerData;
                $ownerId      =  $teamMembers->ownerId;
                
                $member = MatchWiseTeamRecord::create([
                                    "matchId"    =>  $id,
                                    "ownerId"    =>  $ownerId,
                                    "playerData" =>  $playersData,
                                ]);

            }

        }
        \Storage::disk('local')->put('qyhngsd.txt', 'Conteasasasqqqqqnasasts');
    }
}
