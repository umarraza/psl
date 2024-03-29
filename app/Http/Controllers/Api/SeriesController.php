<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Validator;
use App\SeriesMatches;
use App\Series; 
use App\Player; 
// use DB;

use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

// ----- JWT ----- //
use JWTAuthException;
use JWTAuth;

class SeriesController extends Controller
{

    public function create(Request $request)  // Create New Series
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
            $status = NULL;
            if ($request->status == 1) {
                $status = $request->status;
                $status = 'Active';

                DB::table('cric-series')->where('cric-series.status', '=', 'Active')
                                        ->update(['cric-series.status'=> 'Un-Active']);
                $series = Series::create([
                    'seriesName'   =>  $request->seriesName,
                    'status'       =>  $status,
                    'type'         =>  $request->type,
                ]);
                    if($series->save()){
                        return redirect('view-all-series');
                    }else{
                        return "Request Unsuccessfull";
                    }
            }else{            

                // Create series if status is 0 or series is currently not active. 
                $status = NULL;
                if ($request->status == 0) {
                    $status = $request->status;
                    $status = 'Un-Active';
                }
                $series = Series::create([

                    'seriesName'   =>  $request->seriesName,
                    'status'       =>  $status,
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


    public function allSeries(Request $request)
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
            
                $series = Series::all();


                if ($series) {
                    $response['data']['code']       = 200;
                    $response['status']             = true;
                    $response['data']['result']     = $series;
                    $response['data']['message']    = 'Request Successfull';
                }else{
                    $response['data']['code']       = 400;
                    $response['status']             = false;
                    $response['data']['message']    = 'Request Unsuccessfull';
                }
                
        }
        
        return $response;
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
                
                DB::table('cric-series')->where('cric-series.status', '=', 'Active')
                ->update(['cric-series.status'=> 'Un-Active']);

                $status = NULL;

                $status = $request->status;
                $status = 'Active';

                $series              =  Series::find($request->id);
                $series->seriesName  =  $request->seriesName;
                $series->status      =  $status;
                $series->type        =  $request->type;

                if($series->save()){
                    return redirect('view-all-series');
                }else{
                    return "Request Unsuccessfull";
                }

            }
            else
            {

                $status = NULL;
                if ($request->status == 0) {

                    $status = $request->status;
                    $status = 'Un-Active';

                }

                $series              =  Series::find($request->id);
                $series->seriesName  =  $request->seriesName;
                $series->status      =  $status;
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

    public function show()
    {
        $allSeries   =  Series::all();
        $allMatches  =  SeriesMatches::all();

        if ( !empty($allSeries && $allMatches)) {
            
            $noOfSeries   =  count($allSeries);
            $noOfMatches  =  count($allMatches);

            return view('series.viewSeries',compact('allSeries','noOfSeries','noOfMatches'));
        }
    }

    /* ============ Get the data of a single series ============ */

    public function series($id)
    {
        $series = Series::find($id);
        if ($series->status == 'Active') {
            $series->status = 1;
        }else{
            $series->status = 0;
        }
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

    public function activate($id){

        $series = Series::find($id);
        
        if ($series) {

            $series->status = 'Active';

            DB::table('cric-series')->where('cric-series.status', '=', 'Active')
            ->update(['cric-series.status'=> 'Un-Active']);
             
            if ($series->save()){

                return redirect('view-all-series');
            }

        }        
    }
}
