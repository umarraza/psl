<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\SeriesMatches;
use App\Series; 
use App\Player; 
use DB;

class SeriesController extends Controller
{

    /* ============ Create New Series ============ */
    
    public function newSeries(Request $request)
    {

        $rules = [
            'seriesName'  =>  'required|unique:cric-series',
            'status'      =>  'required',
            'type'        =>  'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($rules);
        }else{
            
            /* 
            Status = 1: Series with status 1 mean searies is currently being playing between two countries i.e 
            Pakistan Vs opponent.
            Status = 0: No series is currently being playing between pakistan and 
            opponent team. In order to create series, first check if there is a series with active 
            status = 1 in database. If there is any series avaialble with active status = 1, 
            update it to 0.
            
            */  

            if($request->status == 1){
                DB::table('cric-series')->where('cric-series.status', '=', 1)
                                        ->update(['cric-series.status'=> 0]);
                $series = Series::create([
                    'seriesName'   =>  $request->seriesName,
                    'status'       =>  $request->status,
                    'type'         =>  $request->type,
                ]);
                    if($series->save()){
                        return redirect('view-all-series');
                    }else{
                        return "Request Unsuccessfull";
                    }   
            }else{            
                // Create series if status is 0. 
                $series = Series::create([

                    'seriesName'   =>  $request->seriesName,
                    'status'       =>  $request->status,
                    'type'         =>  $request->type,

            ]);
                if($series->save()){
                    return redirect('view-all-series');
                }else{
                    return "Request Unsuccessfull";
                }
            }
        }
    }

    
    /* ============ Update Series ============ */

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
            if($request->status == 1){
                
                DB::table('cric-series')->where('cric-series.status', '=', 1)
                ->update(['cric-series.status'=> 0]);

                $series              =  Series::find($request->id);
                $series->seriesName  =  $request->seriesName;
                $series->status      =  $request->status;
                $series->type        =  $request->type;

                if($series->save()){
                    return redirect('view-all-series');
                }else{
                    return "Request Unsuccessfull";
                }
            }else{

                $series              =  Series::find($request->id);
                $series->seriesName  =  $request->seriesName;
                $series->status      =  $request->status;
                $series->type        =  $request->type;

                if($series->save()){
                    return redirect('view-all-series');
                }else{
                    return "Request Unsuccessfull";
                }
            }
        // }
    }

    
    /* ============ Show all the Active/Inactive series ============ */

    public function showSeries()
    {
        $allSeries = Series::all();
        $allMatches = SeriesMatches::all();
        if(!empty($allSeries && $allMatches)){
        $noOfSeries = count($allSeries);
        $noOfMatches = count($allMatches);

            return view('series.viewSeries',compact('allSeries','noOfSeries','noOfMatches'));
        }
    }

    /* ============ Get the data of a single series ============ */

    public function series($id)
    {
        $series = Series::find($id);
        if(!empty($series)){
            return view('series.updateSeries',compact('series'));
        }
    }

    /* ===================== Delete Series ===================== */

    public function delete($id){
        $players  =  Player::where('seriesId', '=', $id)->get();
        $matches  =  SeriesMatches::where('seriesId', '=', $id)->get();
        $series   =  Series::find($id);

        if(!empty($players && $matches && $series)){
            $players->each->delete();
            $matches->each->delete();
            $series->delete();

            return redirect('view-all-series');
        }else{
            return "Series not deleted!";
        }
    }
}
