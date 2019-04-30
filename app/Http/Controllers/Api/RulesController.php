<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

// ----- JWT ----- //
use JWTAuthException;
use JWTAuth;

use App\Models\Api\ApiRules as Rules;



class RulesController extends Controller
{
    public function create(Request $request)  // Create New Rule
    {
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code'      => 400,
                    'errors'    => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if ( !empty($user) && $user->isSuperAdmin() )
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];

            $rules = [
                'condition'  =>  'required|unique:rules',
                'points'     =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = "Invalid input values!";
                $response['data']['errors'] = $validator->messages();
            }
            else
            {


                // $api_url  = "http://cricapi.com/api/fantasySummary?apikey=bFm326931rSZTuCWDDlUWHdxDHn2&unique_id=1152566";
                // //  $api_url  = "http://cricapi.com/api/fantasySummary?apikey=<apikey>&unique_id=<unique_id>"
    
                // //  Initiate curl
                // $ch = curl_init();
                // // Disable SSL verification
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                // // Will return the response, if false it print the response
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // // Set the url
                // curl_setopt($ch, CURLOPT_URL,$api_url);
                // // Execute
                // //$result=curl_exec($ch);
                // $result=curl_exec($ch);
                // // Closing
                // return $result;

                // curl_close($ch);

                // $result = str_replace("4s","fourS",$result);
                // $result = str_replace("6s","sixS",$result);
                // $result = str_replace("man-of-the-match","man_of_the_match",$result);

                // return $result;

                // die();

                $condition  =  $request->get('condition');
                $points     =  $request->get('points');

                $rule = Rules::create([
                    "condition"  =>  $condition,
                    "points"     =>  $points,
                ]);

                if (!empty($rule) && $rule->save()) {

                    $response['data']['code']       =   200;
                    $response['status']             =   true;
                    $response['data']['result']     =   $rule;
                    $response['data']['message']    =   'Request Successfull';

                } else{

                    $response['data']['code']       =   400;
                    $response['status']             =   false;
                    $response['data']['message']    =   'Request Unsuccessfull';
                }
	        }
        }
        return $response;
    }

    public function show(Request $request) // Show All Rules
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
        if ( !empty($user) )
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
                
            $rules = Rules::all();

            if (!empty($rules)) {

                $response['data']['code']       =   200;
                $response['status']             =   true;
                $response['data']['result']     =   $rules;
                $response['data']['message']    =   'Request Successfull';

            } else {

                $response['data']['code']       =   400;
                $response['status']             =   false;
                $response['data']['message']    =   'Request Unsuccessfull';
            }
        }
        return $response;
    }

    public function read(Request $request) // Find Single Rule
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

        if ( !empty($user) && $user->isSuperAdmin() )
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $rules = [
                'id'  =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = "Invalid input values!"; // Invalid input values 
                $response['data']['errors'] = $validator->messages();
            } else {

                $id = $request->get('id');
                $rule = Rules::find($id);

                if (!empty($rule)) {

                    $response['data']['code']       =   200;
                    $response['status']             =   true;
                    $response['data']['result']     =   $rule;
                    $response['data']['message']    =   'Request Successfull';

                } else {

                    $response['data']['code']       =   400;
                    $response['status']             =   false;
                    $response['data']['message']    =   'Request Unsuccessfull';
                }
            }
        }
        return $response;
    }

    public function update(Request $request) // Update Rule
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
        if ( !empty($user) && $user->isSuperAdmin() )
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $rules = [
                'id'  =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = "Invalid input values!"; //"'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            } else {

                $id = $request->get('id');
                $rule = Rules::find($id);

                $rule->condition  =  $request->get('condition');
                $rule->points     =  $request->get('points');

                if ($rule->save()) {

                    $response['data']['code']       =   200;
                    $response['status']             =   true;
                    $response['data']['result']     =   $rule;
                    $response['data']['message']    =   'Rule updated successfully!';

                } else {
                    $response['data']['code']       =   400;
                    $response['status']             =   false;
                    $response['data']['message']    =   'Request Unsuccessfull';
                }
            }
        }
        return $response;
    }


    public function delete(Request $request) // Delete Rule
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
        if ( !empty($user) && $user->isSuperAdmin() )
        {
        
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            
            $rules = [
                'id'  =>  'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = "Invalid input values!";//"'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            } else {

                $id = $request->get('id');
                $rule = Rules::find($id);

                if ($rule->delete()) {
                    
                    $response['data']['code']       =   200;
                    $response['status']             =   true;
                    $response['data']['message']    =   'Rule Deleted Successfully!';
                
                } else {
                
                    $response['data']['code']       =   400;
                    $response['status']             =   false;
                    $response['data']['message']    =   'Request Unsuccessfull';
                
                }
            }
        }
        return $response;
    }

    public function updateRule(Request $request){

        $id = $request->id;
        
        $rule = Rules::find($id);
        
        $rule->points = $request->points; 

        if ($rule->save()) {
            
            return redirect('/show-all-rules');
        }
    }

    public function ruleData($id) {
        
        $rule = Rules::find($id);

        if (!empty($rule)){
            return view('update-rules', compact('rule'));
        }
    }
}
