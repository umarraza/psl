<?php
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\SeriesMatches;
use App\Models\Api\ApiRules as Rules;
use App\Models\Api\ApiSeriesTeam as SeriesTeam;

use App\Series;  

    Auth::routes();

    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::get('/create-matches-form/{id}', function ($id) {
        $allTeams = SeriesTeam::all();
        return view('matches.createMatches', compact('id', 'allTeams'));
    });
    Route::get('/create-series', function () {
        return view('series.createSeries');
    });
    Route::get('/show-all-rules', function () {
        $rules = Rules::all();
        return view('rules', compact('rules'));
    });

    Route::get('/create-player-form/{id}', function ($id) {
        $series = Series::where('id', '=', $id)->first();
        $seriesId = $series->id;

        if(!empty($series && $seriesId)){
            return view('players.createPlayers', compact('seriesId', 'id'));
        }
    });

    Route::get('/create-team-form/{id}', function ($id) {
        $seriesId = $id;
        return view('teams.createTeam', compact('seriesId'));

    });

    Route::group(['middleware' => ['web']], function () {
        
                    /* ====== Series Routes ====== */
    Route::post('/new-series','Api\SeriesController@create');				
    Route::get('/view-all-series','Api\SeriesController@show');
    Route::post('/update-series','Api\SeriesController@update');	
    Route::get('/delete-series/{id}','Api\SeriesController@delete');
    Route::get('/update-series-form/{id}','Api\SeriesController@series'); 	
    Route::get('/activate-series/{id}','Api\SeriesController@activate'); 	
   
   
                    /* ====== Match Routes ====== */

    Route::post('/new-match','Api\SeriesMatchesController@create');				
    Route::get('/view-all-matches/{id}','Api\SeriesMatchesController@show');
    Route::get('/delete-match/{id}','Api\SeriesMatchesController@delete');				
    Route::get('/update-match-form/{id}','Api\SeriesMatchesController@match');	
    Route::post('/update-match','Api\SeriesMatchesController@update');	
    
    
                /* ====== Players Routes ====== */
    Route::post('/new-player','Api\PlayersController@store');                                          			
    Route::get('/view-all-players/{id}','Api\PlayersController@show');
    Route::get('/delete-player/{id}','Api\PlayersController@delete');	
    Route::post('/update-player','Api\PlayersController@update');	
    Route::get('/update-player-form/{id}','Api\PlayersController@player');	
    });

                /* ====== Rules Routes ====== */

    Route::post('/update-rule/{id}','Api\RulesController@updateRule');	
    Route::get('/show-rules','Api\RulesController@show');	

    Route::get('/update-rule-form/{id}','Api\RulesController@ruleData');	

                /* ====== Teams Routes ====== */

    Route::post('/new-team','Api\MatchController@addTeam');                                          			
    Route::get('/view-teams/{id}','Api\MatchController@show');
    Route::get('/delete-team/{id}','Api\MatchController@delete');






























// GET APP STOP STATUS
Route::get('/','Api\AppCommandController@abc');
Route::get('as/', function () {
    
     $ip = \Request::ip();

        //$data = \Location::get("182.185.179.2");


        dd($ip);
    
  //  $user = User::find(14);
    
    //$user->sendEmailCustomer("asas","6556163");
    // \Mail::send('mail',["fName"=>"Hasseeb","lName"=>"Sohail","leagueName"=>"ABC","accessCode"=>"14511321465",], function ($message) {
    //         $message->from('info@fantasycricleague.online', 'New League');
    //         $message->to("hassanamir210@gmail.com")->subject('New League is Created!');
    //     });
//    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
