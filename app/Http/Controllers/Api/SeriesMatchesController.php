<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SeriesMatches;
use App\Player; 
use DB;
use Illuminate\Support\Facades\View;
use Validator;

class SeriesMatchesController extends Controller
{

    public function newMatch(Request $request)
    {

        $rules = [
            'teamA'        =>  'required',
            'teamB'        =>  'required',
            'dateTimeGMT'  =>  'required',
            'startingTime' =>  'required',
            'endingTime'   =>  'required',
            'format'       =>  'required',
            'status'       =>  'required',
            'seriesId'     =>  'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($rules);
        }else{

        /* 
        Status = 1: Match with status 1 mean match is currently being playing between two countries i.e 
        Pakistan Vs opponent.
        Status = 0: No match is currently being playing between pakistan and 
        opponent team. In order to create new match, first check if there is a match with active 
        status = 1 in database. If there is any match avaialble with active status = 1, 
        update it to 0 pakistani team can play one match at a time.
        
        */  

            if($request->status == 1){
                    
                    DB::table('series_matches')->where('series_matches.status', '=', 1)
                    ->update(['series_matches.status'=> 0]);

                $match = SeriesMatches::create([

                    'teamA'          =>   $request->teamA,
                    'teamB'          =>   $request->teamB,
                    'dateTimeGMT'    =>   $request->dateTimeGMT,
                    'startingTime'   =>   $request->startingTime,
                    'endingTime'     =>   $request->endingTime,
                    'format'         =>   $request->format,
                    'status'         =>   $request->status,
                    'seriesId'       =>   $request->seriesId,

                ]);

                $id = $request->seriesId;

                if(!empty($match)){
                    if($match->save()){
                        return redirect("view-all-matches/$id");
                    }
                }
            }else{ // Create match if status is '0'
                $match = SeriesMatches::create([

                    'teamA'          =>   $request->teamA,
                    'teamB'          =>   $request->teamB,
                    'dateTimeGMT'    =>   $request->dateTimeGMT,
                    'startingTime'   =>   $request->startingTime,
                    'endingTime'     =>   $request->endingTime,
                    'format'         =>   $request->format,
                    'status'         =>   $request->status,
                    'seriesId'       =>   $request->seriesId,

                ]);

                $id = $request->seriesId;

                if(!empty($match)){
                    if($match->save()){
                        return redirect("view-all-matches/$id");
                    }
                }
            }
        }
    }

    // Update match details
    public function update(Request $request){

        // $rules = [
        //     'teamA'        =>  'required',
        //     'teamB'        =>  'required',
        //     'dateTimeGMT'  =>  'required',
        //     'startingTime' =>  'required',
        //     'endingTime'   =>  'required',
        //     'format'       =>  'required',
        //     'status'       =>  'required',
        //     'seriesId'     =>  'required',
        // ];

        // $validator = Validator::make($request->all(), $rules);
        // if($validator->fails()){
        //     return redirect()->back()->withErrors($rules);
        // }else{
            if($request->status == 1){
                DB::table('series_matches')->where('series_matches.status', '=', 1)
                ->update(['series_matches.status'=> 0]);

                $match   =  SeriesMatches::find($request->id);

                $match->teamA         =  $request->teamA;
                $match->teamB         =  $request->teamB;
                $match->dateTimeGMT   =  $request->dateTimeGMT;
                $match->startingTime  =  $request->startingTime;
                $match->endingTime    =  $request->endingTime;
                $match->format        =  $request->format;
                $match->status        =  $request->status;

                $id = $match->seriesId;
                if(!empty($match)){
                    if($match->save()){
                        return redirect("view-all-matches/$id");
                    }else{
                        return "Request Unsuccessfull";
                    }
                }
            }else{

                $match                =  SeriesMatches::find($request->id);
                $match->teamA         =  $request->teamA;
                $match->teamB         =  $request->teamB;
                $match->dateTimeGMT   =  $request->dateTimeGMT;
                $match->startingTime  =  $request->startingTime;
                $match->endingTime    =  $request->endingTime;
                $match->format        =  $request->format;
                $match->status        =  $request->status;
                $id                   =  $match->seriesId;

                if(!empty($match)){
                    if($match->save()){
                        return redirect("view-all-matches/$id");
                    }else{
                        return "Request Unsuccessfull";
                    }
                }
            }
        // }
    }
    
    // Show all matches relevant to a particular series
    public function show($id)
    {   
        $matches = SeriesMatches::where('seriesId', '=', $id)->get();
        if(!empty($matches)){
            return view('matches.viewMatches',compact('matches', 'id'));
        }else{
            return "No Matches Found!";
        }
    }

    // Delete match from a series

    public function delete($id){
        $match     =  SeriesMatches::find($id);
        $players   =  Player::where('matchId', '=', $id)->get();
        $seriesId  =  $match->seriesId;
        
        if(!empty($match && $players && $seriesId)){
           if( $players->each->delete()){
                if($match->delete()){
                    return redirect("view-all-matches/$seriesId");
                }else{
                    return "Match did not deleted!";
                }
            }else{
                return "Players did not deleted!";
            }
        }else{
            return "Request Unsuccessfull";
        }
    }

    public function matchData($id)
    {
        $match = SeriesMatches::find($id);
    	return view('matches.updateMatch',compact('match'));
    }

}
