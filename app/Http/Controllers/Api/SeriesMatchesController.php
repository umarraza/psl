<?php   

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

use DB;
use Validator;
use App\Models\Api\ApiMatch as SeriesMatches;
use App\Models\Api\ApiPlayer as Player;
use App\Models\Api\ApiSeriesTeam as SeriesTeam;

class SeriesMatchesController extends Controller
{

    public function create(Request $request)
    {
        $rules = [

            'teamA'         =>   'required',
            'teamB'         =>   'required',
            'unique_id'     =>   'required',
            'date'          =>   'required',
            'dateTimeGMT'   =>   'required',
            // 'type'          =>   'required',
            // 'squad'         =>   'required',
            'matchStarted'  =>   'required',
            'seriesId'      =>   'required',
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
            // return $request->teamA;
            // $team  = SeriesTeam::find(1);
            // $request->teamA;
            $teamA = SeriesTeam::where("team", "=", $request->teamA)->first();
            $teamB = SeriesTeam::where("team", "=", $request->teamB)->first();
            $teamAId = $teamA->id;
            $teamBId = $teamB->id;

            $match = SeriesMatches::create([

                'teamA'         =>   $request->teamA,
                'teamB'         =>   $request->teamB,
                'teamAId'       =>   $teamAId,
                'teamBId'       =>   $teamBId,
                'unique_id'     =>   $request->unique_id,
                'date'          =>   $request->date,
                'dateTimeGMT'   =>   $request->dateTimeGMT,
                'type'          =>   $request->type,
                'squad'         =>   $request->squad,
                'matchStarted'  =>   $request->matchStarted,
                'seriesId'      =>   $request->seriesId,

            ]);

            $id = $request->seriesId;

            if(!empty($match)){
                if($match->save()){
                    return redirect("view-all-matches/$id");
                }
            }
        }
    }

    // Update match details
    public function update(Request $request){

        $rules = [

            'teamA'         =>  'required',
            'teamB'         =>  'required',
            'unique_id'     =>  'required',
            'date'          =>  'required',
            'dateTimeGMT'   =>  'required',
            'matchStarted'  =>  'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($rules);
        }else{

                $match   =  SeriesMatches::find($request->id);

                $match->teamA          =  $request->teamA;
                $match->teamB          =  $request->teamB;
                $match->unique_id      =  $request->unique_id;
                $match->date           =  $request->date;
                $match->dateTimeGMT    =  $request->dateTimeGMT;
                $match->matchStarted   =  $request->matchStarted;

                $id = $match->seriesId;
                if(!empty($match)){
                    if($match->save()){
                        return redirect("view-all-matches/$id");
                    }else{
                        return "Request Unsuccessfull";
                    }
                }
        }
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

    public function match($id)
    {
        $match = SeriesMatches::find($id);

        if ($match->status == 'Active') {
            $match->status = 1;
        }else{
            $match->status = 0;
        }

    	return view('matches.updateMatch',compact('match'));
    }

}
