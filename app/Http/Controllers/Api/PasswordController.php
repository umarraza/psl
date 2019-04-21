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

//// Carbon ////
use Carbon\Carbon;
use DateTime;

//// Models ////
use App\Models\Api\ApiUser as User;

class PasswordController extends Controller
{
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
	      		if($user->roleId==2)
	      		{
	      			$name = $user->player->firstName;
	      		}
	      		elseif($user->roleId==3)
	      		{
	      			// Some Role
	      		}
	      		else if($user->roleId==4)
	      		{
	      			// Some Role
	      		}
	      		else if($user->roleId==5)
	      		{
	      			// Some Role
	      		}
	      		else
	      		{
	      			$name="Super Admin";
	      		}

	      		if($name!="Super Admin")
	      		{
		      		$token = md5(time() . $user->id . 'waves');
		      		$user->resetPasswordToken = $token;

		      		$now = Carbon::now();//->format('Y-m-d H:i:s');
		      		$user->createdResetPToken = $now;

					if ($user->save() && $user->sendEmailForgotPassword($token,$name)) 
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
			else
			{
				$response['data']['message'] = 'If this email matches our record, we will send an email containing instructions to reset password.';
				$response['data']['code'] = 400;
				$response['status'] = true;
			}
		}
		return $response;
	}

	public function changePasswordWeb(Request $request)
    {
	  	$response = [
	      	'data' => [
	          	'code' => 400,
	         	'message' => 'Something went wrong. Please try again later!',
	      	],
	     	'status' => false
	  	];
	  	$rules = [
	     	'userId' 		=> 	'required',
	     	'newPassword' 	=>	'required|string|min:5',
	     	'token' 		=>	'required',
	  	];
	  	$validator = Validator::make($request->all(), $rules);
	  	if ($validator->fails()) {
	    	$response['data']['message'] = 'Invalid input values.';
	      	$response['data']['errors'] = $validator->messages();
	  	}else
	  	{

	      	$user= User::find($request->userId);

	      	if(!empty($user))
	      	{
				if($user->resetPasswordToken==$request->token)
				{
					$start  = new DateTime($user->createdResetPToken);
					$end    = new DateTime(); //Current date time
					$diff   = $start->diff($end);

					if($diff->d<=0)
					{
						$user =  User::where('id', $request->get('userId'))
							            ->update([
							            	'password' => bcrypt($request->get('newPassword')),
							            	'verified' => '1',
							            	'resetPasswordToken' => Null,
							            ]); 
						if ($user) 
						{
							$response['data']['message'] = 'Request Successfull';
							$response['data']['code'] = 200;
							$response['status'] = true;
						}
					}
					else
					{
						$response['data']['message'] = 'Token expired';
						$response['data']['code'] = 400;
						$response['status'] = true;
					}

				}
				else
				{
					$response['data']['message'] = 'Invalid Token';
					$response['data']['code'] = 400;
					$response['status'] = true;
				}
			}
			else
			{
				$response['data']['message'] = 'User Does not exist';
				$response['data']['code'] = 400;
				$response['status'] = true;
			}
	  	}
		return $response;
    }
}
