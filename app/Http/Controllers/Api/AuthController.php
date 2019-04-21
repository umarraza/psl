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

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // inializing a default response in case of something goes wrong.
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid credentials or missing parameters',
                ],
                'status' => false
            ];

        if($request['facebook_login'] == "F")
        {
            $checkAvailable =  User::where('username','=',$request->username)->first();

            if(!empty($checkAvailable))
            {

            }
            else
            {
                $createNew = User::create([
                                'username'  => $request->get('username'),
                                'password'  => bcrypt($request->get('password')),
                                'resetPasswordToken' => $request->get('password'),
                                'roleId'    => 2,
                                'verified'  => User::STATUS_ACTIVE,
                                'language'  => "english",
                            ]);


                if($createNew)
                {
                    $teamOwner = TeamOwner::create([
                        'firstName'             => $request->get('firstName'),
                        'lastName'              => $request->get('lastName'),
                        'mobileNumber'          => "NONE",
                        'userId'                => $createNew->id,
                        'moves'                 => 120,
                        'amountInAccount'       => 1100000000,
                    ]);


                    if($teamOwner)
                    {

                    }
                    else
                    {
                        return $response;
                    }
                }
                else
                {
                    return $response;
                }
            }   
        }



        // checking if parameters are set or not
        if(isset($request['username'],$request['password'])){

            // authenticate token from username and passwrod
            $credentials = $request->only('username', 'password');
            $token = null;
            try {
               if (!$token = JWTAuth::attempt($credentials)) {
                    return [
                        'data' => [
                            'code' => 400,
                            'message' => 'Email or password wrong.',
                        ],
                        'status' => false
                    ];
               }
            } catch (JWTAuthException $e) {
                return [
                        'data' => [
                            'code' => 500,
                            'message' => 'Fail to create token.',
                        ],
                        'status' => false
                    ];
            }
            // Finding User from token.
            $user = JWTAuth::toUser($token);
            // Checking if user is valid or not.
            if($user->isValidUser())
            {
                if($user->isTeamOwner())
                {
                    
                    $response['data']['code']               = 200;
                    $response['data']['message']            = "Request Successfull!!";
                    $response['data']['token']              = User::loginUser($user->id,$token);
                    $response['data']['result']['teamOwner']= $user->teamOwner->getArrayResponse();
                    $response['data']['result']['userData'] = $user->getArrayResponse();
                    $response['status']= true;    
                }
                elseif($user->isSuperAdmin())
                {
                    $response['data']['code']               = 200;
                    $response['data']['message']            = "Request Successfull!!";
                    $response['data']['token']              = User::loginUser($user->id,$token);
                    $response['data']['result']['userData'] = $user->getArrayResponse();
                    $response['status']= true;
                }   
            }
            else
            {   
                // response if user is not valid.
                $response['data']['message'] = 'Not a valid user';
            }
        }
        return $response;
    }
    
    public function forgotPassword(Request $request)
    {
    	$response = [
	      	'data' => [
	          	'code' => 400,
	         	'message' => 'Something went wrong. Please try again later!',
	      	],
	     	'status' => false
		];
	  	$rules = [
	     	'username' => ['required','exists:users,username'],
	  	];
	  	$validator = Validator::make($request->all(), $rules);
	  	if ($validator->fails()) {
	    	$response['data']['message'] = 'Invalid input values.';
	      	$response['data']['errors'] = $validator->messages();
	  	}else
	  	{
    		$user= User::where('username','=',$request->username)->first();
    		
      		if($user->verified)
	      	{
	      	    if($user->resetPasswordToken==null)
	      	    {
	      	        $newPassword = $user->teamOwner->firstName.$user->teamOwner->id;
	      	        $user->resetPasswordToken = $newPassword;
	      	        $user->password = bcrypt($newPassword);
	      	        $user->save();
	      	    }
				if ($user->sendEmailForgotPassword()) 
				{
					$response['data']['message'] = 'Request Successfull';
					$response['data']['code'] = 200;
					$response['status'] = true;
				}
			}
			else
			{
				$response['data']['message'] = 'If this email matches our record, we will send an email containing instructions to reset password.';
				$response['data']['code'] = 400;
				$response['status'] = true;
			}
		}
		return $response;
	}

    public function isValidToken(Request $request){
        // validating token if mobile device is already logged in.
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user)){
            $response['status'] = true;
            $response['data']['code'] = 200;
            $flag = false;
            if(($user->isAdmin() || $user->isSecondaryAdmin()) && !$user->isVerified()){
                $flag = true;
                $user->verified = User::STATUS_ACTIVE;
                $user->save();
            }      
            $token = $request->token;
            $code = $response['data']['code'];  
            $response['data'] = User::loginUser($user->id,$token,'Valid Token');
            $response['data']['code'] = $code; 
            if($user->isAdmin()){
                if($flag)
                    $response['data']['code'] = 300;

                $response['data']['school'] = base64_encode(json_encode($user->schoolAdminProfile->getResponseData()));
                //$response['data']['user'] = base64_encode(json_encode("Login"));
            }
            elseif($user->isSecondaryAdmin()){
                if($flag)
                    $response['data']['code'] = 300;
                //$response['data']['user'] = $user->schoolSecondaryAdminProfile->getResponseData();
                $response['data']['school'] = base64_encode(json_encode($user->schoolSecondaryAdminProfile->getResponseData()));
                //$response['data']['user'] = base64_encode(json_encode("Login"));
            }elseif($user->isResponder())
            {
                // Checking if User is already login in to other devices or not
                $loginFlag = false;
                if($request->deviceType=="M")
                {
                    if($user->deviceToken!=null)
                    {
                        $loginFlag = true;
                    }
                }    
                if($loginFlag)
                {
                    $response = [
                                    'data' => [
                                        'code' => 420,
                                        'message' => 'Already Login to the other device. Log out first',
                                    ],
                                    'status' => false
                                ];
                }
                else
                {
                    $response['data']['user'] = base64_encode(json_encode($user->responder->getResponseData()));
                    $response['data']['school'] = base64_encode(json_encode($user->responder->schoolProfile->schoolAdminProfile->getResponseData()));
                }
            }
            elseif($user->isStudent())
            {
                // Checking if User is already login in to other devices or not
                $loginFlag = false;
                if($request->deviceType=="M")
                {
                    if($user->deviceToken!=null)
                    {
                        $loginFlag = true;
                    }
                }    
                if($loginFlag)
                {
                    $response = [
                                    'data' => [
                                        'code' => 420,
                                        'message' => 'Already Login to the other device. Log out first',
                                    ],
                                    'status' => false
                                ];
                }
                else
                {
                    $response['data']['user'] = base64_encode(json_encode($user->student->getResponseData()));
                    $response['data']['school'] = base64_encode(json_encode($user->student->schoolProfile->schoolAdminProfile->getResponseData()));
                }
            }
        }
        return $response;
    }

    public function logout(Request $request){

        // validation user from token.
        $user = JWTAuth::toUser($request->token);
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user)){
            // if user is valid then expire its token.
            JWTAuth::invalidate($request->token);
            
            // if logout occur from mobile device then clear the device token.
            if($request->deviceType=="M")
                $user->clearDeviceToken();

            $response['data']['message'] = 'Logout successfully.';
            $response['data']['code'] = 200;
            $response['status'] = true;
        }
        return $response;
    }

    public function updateUserDevice(Request $request){
        // validation token.
        $user = JWTAuth::toUser($request->token);
        // generating default response if something gets wrong.
        $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        if(!empty($user)){
            // rules to check weather paramertes comes or not.
            $rules = [
                'deviceToken' => 'required',
                'deviceType' => 'required|Numeric|in:0,1'
            ];
            // validating rules
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                // saving success response.
                $response['status'] = true;
                $response['data']['code'] = 200;
                $response['data']['message'] = 'Request Successfull.';
                $model = User::where('id','=',$user->id)->first();
                // updating token
                if(!empty($model)){
                    $model->update([
                        'deviceToken' => $request->deviceToken,
                        'deviceType' => $request->deviceType
                    ]);
                }
                else
                {
                    // in cans token update is unsuccessfull.
                    $response['data']['message'] = 'Device token not saved successfully. Please try again.';
                }
            }
        }
        return $response;
    }


    // Update Online Status for User
    public function updateOnlineStatus(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        // generating default response if something gets wrong.
        $response = [
                'data' => [
                    'code'      => 400,
                    'error'     => '',
                    'message'   => 'Invalid Token! User Not Found.',
                ],
                'status' => false
            ];
        // checking if user exists or not
        if(!empty($user))
        {
            $response = [
                'data' => [
                    'code' => 400,
                    'message' => 'Something went wrong. Please try again later!',
                ],
               'status' => false
            ];
            $rules = [
               'status'   => ['required', 'in:0,1']
            ];
            // valiating that weather status comes from front-end or not And its value should be in 0,1
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response['data']['message'] = 'Invalid input values.';
                $response['data']['errors'] = $validator->messages();
            }else
            {
                $response['status'] = true;
                $response['data']['code'] = 401;
                $isSaved = User::where('id','=',$user->id)
                                ->update(['onlineStatus' => $request->status]);
                // updating status in db and if successfully updated send success response.
                if($isSaved){
                    $response['data']['code'] = 200;
                    $response['data']['message'] = 'Request Successfull';
                }
            }
        }   
        return $response;
    }


}
