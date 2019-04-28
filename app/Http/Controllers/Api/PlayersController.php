<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\SeriesMatches;
use App\Series; 
use App\Player; 
use DB;

class PlayersController extends Controller
{
     // Create New Player
     public function store(Request $request)
     {

         $rules = [
            
            'name'         =>  'required',
            'designation'  =>  'required',
            // 'pid'          =>  'required',
            // 'image'        =>  'required',
            'nameOfTeam'   =>  'required',
            'matchId'      =>  'required',
            'seriesId'     =>  'required',

        ];
         
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($rules);
        }else{

                $player = Player::create([

                'name'         =>  $request->name,
                'designation'  =>  $request->designation,
                'pid'          =>  $request->pid,
                'image'        =>  $request->image,
                'nameOfTeam'   =>  $request->nameOfTeam,
                'matchId'      =>  $request->matchId,
                'seriesId'     =>  $request->seriesId,
        ]);

            $id = $request->matchId;
            if($player->save()){
                return redirect("view-all-players/$id");
            }else{
                return "Request Unsuccessfull";
            }   
        }
    }
 
     //  Update Series
 
    public function update(Request $request)
    {
         // $rules = [
         //     'seriesName'  =>  'required|unique:cric-series',
         //     'status'      =>  'required',
         //     'type'        =>  'required',
         // ];
 
         // $validator = Validator::make($request->all(), $rules);
         // if($validator->fails()){
         //     return redirect()->back()->withErrors($rules);
         // }else{
                 
                $player  =  Player::find($request->id);
                $matchId = $player->matchId;
                $player->name          =  $request->name;
                $player->designation   =  $request->designation;
                $player->nameOfTeam    =  $request->nameOfTeam;
 
                if($player->save()){
                    return redirect("view-all-players/$matchId");
                }else{
                    return "Request Unsuccessfull";
                }
         // }
    }
 
     // Show all Players
    public function show($id)
    {
        $players = Player::where('seriesId', '=', $id)->get();
        // $matchId = NULL;
        // foreach($players as $player){
        //     $id  =  $player->matchId;
        // }
        if(!empty($players)){
            return view("players.viewPlayers",compact('players','id'));
        }
    }
 
     //  Get the data of a single player
 
    public function player($id)
    {
        $player = Player::find($id);
        if(!empty($player)){
            return view('players.updatePlayers',compact('player', 'id'));
        }
    }
    
    public function delete($id){
        $player = Player::find($id);
        $seriesId = $player->seriesId;
        if(!empty($player)){
            $player->delete();
            return redirect("view-all-players/$seriesId");
        }
    }

}
