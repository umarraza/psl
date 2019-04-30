<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Login
Route::post('/login', 'Api\AuthController@login');

// Player SignUp
Route::post('team-owner-signup','Api\TeamOwnerController@signUp');

// Forgot Password
Route::post('forgot-password', 'Api\AuthController@forgotPassword');

// Reset Password
Route::post('reset-passwords','Api\PasswordController@changePasswordWeb');

// List Players With out Token
Route::get('list-players-without-token','Api\PlayerController@listPlayersWithoutToken');

    // Team OWNER DATA MOBILE
    Route::get('upMy','Api\TeamOwnerController@upMy');
Route::group(['middleware' => 'jwt.auth'], function () {


	//=========================== Players =========================//

    // ADD Player
    Route::post('add-player','Api\PlayerController@addPlayer');

    // ADD Player Image
    Route::post('add-player-image','Api\PlayerController@addPlayerImage');

    // ADD Player Team
	Route::post('add-player-team','Api\PlayerController@addPlayerTeam');

	// Edit Player
	Route::post('edit-player','Api\PlayerController@editPlayer');

	// Delete Player
	Route::post('delete-player','Api\PlayerController@deletePlayer');

	// List Players
	Route::get('list-players','Api\PlayerController@listPlayers');



	//=========================== Matches =========================//

    // ADD Match
	Route::post('add-match','Api\MatchController@addMatch');

	// Edit Match
	Route::post('edit-match','Api\MatchController@editMatch');

	// Delete Match
	Route::post('delete-match','Api\MatchController@deleteMatch');

	// List Matches
	Route::get('list-matches','Api\MatchController@listMatches');

	Route::get('all-teams','Api\MatchController@listTeams');


	//=========================== Team Owners =========================//

    // UpdateInfo of Team Owners
    Route::post('team-owner-update-info','Api\TeamOwnerController@updateInformation');


    // Update Team Members
    Route::post('update-team-members','Api\TeamOwnerController@updateTeamMembers');

    // UpdateInfo of Team Owners
    Route::get('list-team-members','Api\TeamOwnerController@listTeamMembers');


    // Team OWNER DATA MOBILE
    Route::get('team-owner-data','Api\TeamOwnerController@getTeamOwnerData');
    




    //=========================== App Commands =========================//

    // GET APP STOP STATUS
    Route::get('get-app-stop-status','Api\AppCommandController@getAppStopStatus');

    // SET APP STOP STATUS
    Route::get('set-app-stop-status','Api\AppCommandController@changeAppStopStatus');


    //=========================== Stats =========================//

    // GET APP STOP STATUS
    Route::get('update-app-stats','Api\StatsController@updateStats');



    //=========================== Leagues =========================//

    // Add new Leagues
    Route::post('add-new-league','Api\LeagueController@addNewLeague');

    // Join Leagues
    Route::post('join-league','Api\LeagueController@joinLeague');

    // List Leagues
    Route::get('list-leagues','Api\LeagueController@listLeagues');

    // List Top Scorers
    Route::post('league-top-scorers','Api\LeagueController@listLeagueTopTens');

    // Delete
    Route::post('delete-league','Api\LeagueController@deleteLeague');
    Route::get('top-ten-info','Api\TeamOwnerController@listTopTen');
    
    // Get Match Wise Stats
    Route::post('match-wise-stats','Api\RecordsController@listTeamMembers');
    
    // Get Match Wise Stats
    Route::post('match-wise-stats-test','Api\RecordsController@updateRecords');
    
    //=========================== Rules Routes =========================//

    Route::post('create-rule','Api\RulesController@create');
    Route::get('show-rules','Api\RulesController@show');
    Route::post('get-rule','Api\RulesController@read');
    Route::post('update-rule','Api\RulesController@update');
    Route::post('delete-rule','Api\RulesController@delete');

// ------------- Series Routes ---------------- //

    Route::get('show-all-series','Api\SeriesController@allSeries');
    Route::post('show-all-matches','Api\MatchController@allMatches');
    Route::post('show-all-players','Api\PlayerController@allPlayers');
    Route::post('show-all-teams','Api\MatchController@allTeams');
    Route::post('/check','Api\TeamsController@check');
    
});
Route::get('abc-test','Api\StatsController@abcTest');

Route::get('localTestRoute',function()
{

	$response = [
            
        'data' => 
            [
                'code' => 400,
                'message' => 'I Love You :*',
            ],

            'status' => false
    ];
    return $response;
});
